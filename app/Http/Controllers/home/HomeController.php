<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Exception;
use Carbon\Carbon;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;

class HomeController extends Controller
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->shareData();
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client([
            'base_uri' => $this->baseUri,
            'timeout' => 5,          // máx 5s por petición individual
            'connect_timeout' => 3,  // máx 3s para conectar
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();

                $sesionInvalida = collect($sesion)->slice(0, 3)->contains(fn($val) => empty($val)) || !$sesion[3];

                if ($sesionInvalida) {
                    return redirect()->route('login');
                }

                $ventaDiaMes = $this->ventaDiaMes();
                $entradaDiaMes = $this->entradaDiaMes();
                $tendencia = $this->tendenciaUltimosDias(7);

                return view('home.index', compact('ventaDiaMes', 'entradaDiaMes', 'tendencia'));

            }
        } catch (Exception $e) {
            alert()->error("Exception Index Usuario!");
            return redirect()->to(route('login'));
        }
    }


    // ======================================================================
    // ======================================================================

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    // ======================================================================
    // ======================================================================

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    // ======================================================================
    // ======================================================================

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // ======================================================================
    // ======================================================================

    public function ventaDiaMes()
    {
        $hoy = Carbon::today()->toDateString();
        $inicioMes = Carbon::now()->startOfMonth()->toDateString();

        try {
            $peticion = $this->clientApi->get($this->baseUri. 'venta_dia_mes', [
                'query' => [
                    'fecha_venta_dia' => $hoy,
                    'fecha_venta_inicio_mes' => $inicioMes,
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $resultado = json_decode($peticion->getBody()->getContents());
            return $resultado ?? ['ventasDia' => 0, 'ventasMes' => 0];

        } catch (Exception $e) {
            return ['ventasDia' => 0, 'ventasMes' => 0];
        }
    }

    // ======================================================================
    // ======================================================================

    public function entradaDiaMes()
    {
        $hoy = Carbon::today()->toDateString();
        $inicioMes = Carbon::now()->startOfMonth()->toDateString();

        try {
            $peticion = $this->clientApi->get($this->baseUri. 'entrada_dia_mes', [
                'query' => [
                    'fecha_entrada_dia' => $hoy,
                    'fecha_entrada_inicio_mes' => $inicioMes,
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            $resultado = json_decode($peticion->getBody()->getContents());
            return $resultado ?? ['entradasDia' => 0, 'entradasMes' => 0];

        } catch (Exception $e) {
            return ['entradasDia' => 0, 'entradasMes' => 0];
        }
    }

    // ======================================================================
    // ======================================================================

    /**
     * Arma el array de tendencia (labels, ventas, compras) para los
     * últimos $dias días, usando los endpoints existentes, pero disparando
     * TODAS las peticiones en paralelo (async) en vez de una por una.
     * Esto evita el timeout de 60s que da PHP con llamadas secuenciales.
     * Se cachea 15 min por empresa para no golpear la API en cada recarga.
     *
     * @param  int  $dias
     * @return array{labels: array, ventas: array, compras: array}
     */
    public function tendenciaUltimosDias(int $dias = 7): array
    {
        $idEmpresa = session('empresa_actual.id_empresa');
        $cacheKey = "tendencia_dashboard_{$idEmpresa}_{$dias}_" . Carbon::today()->toDateString();

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($dias, $idEmpresa) {

            $fechas = [];
            for ($i = $dias - 1; $i >= 0; $i--) {
                $fechas[] = Carbon::today()->subDays($i)->toDateString();
            }

            // Disparamos las 14 peticiones (7 ventas + 7 compras) al mismo tiempo,
            // sin esperar respuesta una por una.
            $promesas = [];
            foreach ($fechas as $fecha) {
                $promesas["venta_{$fecha}"] = $this->clientApi->getAsync('venta_dia_mes', [
                    'query' => [
                        'fecha_venta_dia' => $fecha,
                        'fecha_venta_inicio_mes' => $fecha,
                        'empresa_actual' => $idEmpresa,
                    ],
                ]);
                $promesas["compra_{$fecha}"] = $this->clientApi->getAsync('entrada_dia_mes', [
                    'query' => [
                        'fecha_entrada_dia' => $fecha,
                        'fecha_entrada_inicio_mes' => $fecha,
                        'empresa_actual' => $idEmpresa,
                    ],
                ]);
            }

            // Esperamos a que todas terminen (o fallen) sin que un error tumbe las demás.
            $resultados = Utils::settle($promesas)->wait();

            $labels = [];
            $ventas = [];
            $compras = [];

            foreach ($fechas as $fecha) {
                $labels[] = Carbon::parse($fecha)->translatedFormat('D d');
                $ventas[]  = $this->extraerValorRespuesta($resultados["venta_{$fecha}"] ?? null, 'ventasDia');
                $compras[] = $this->extraerValorRespuesta($resultados["compra_{$fecha}"] ?? null, 'entradasDia');
            }

            return [
                'labels' => $labels,
                'ventas' => $ventas,
                'compras' => $compras,
            ];
        });
    }

    // ======================================================================
    // ======================================================================

    /**
     * Extrae un campo numérico del resultado de una promesa de Guzzle
     * (Utils::settle), devolviendo 0 si la petición falló o el campo no existe.
     *
     * @param  array|null  $resultadoSettle  Entrada del array que devuelve Utils::settle()
     * @param  string      $campo            Nombre del campo a extraer (ej. 'ventasDia')
     * @return float
     */
    private function extraerValorRespuesta(?array $resultadoSettle, string $campo): float
    {
        if (!$resultadoSettle || $resultadoSettle['state'] !== 'fulfilled') {
            return 0;
        }

        try {
            $body = json_decode($resultadoSettle['value']->getBody()->getContents());
            return $body->{$campo} ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
}