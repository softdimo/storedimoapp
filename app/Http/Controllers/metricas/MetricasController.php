<?php

namespace App\Http\Controllers\metricas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Responsable\metricas\MetricaIndex;
use Exception;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;

class MetricasController extends Controller
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->shareData();
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();

                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else {
                    $metricasIndex = (new MetricaIndex())->toResponse($request);
        
                    return view('metricas.index', compact('metricasIndex'));
                }
            }
        } catch (Exception $e) {
            alert()->error("Exception Index Métricas!");
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
        //
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
        //
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
    public function edit($idCliente)
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

    // 1. Total absoluto de las peticiones de todas las BD
    public function queryTotalAbsoluto(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/query_total_absoluto', [
                'json' => [
                    'fecha_inicial_metrica' => $request->input('fecha_inicial_metrica'),
                    'fecha_final_metrica' => $request->input('fecha_final_metrica')
                ]
            ]);

            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            alert()->error('Consultando el valor absoluto de peticiones al servidor, contacte a Soporte.');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    // 2. Subtotal por Actividad
    public function querySubtotalActividad(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/query_subtotal_actividad', [
                'json' => [
                    'fecha_inicial_metrica' => $request->input('fecha_inicial_metrica'),
                    'fecha_final_metrica' => $request->input('fecha_final_metrica')
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error consultando subtotal por actividad.');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    // 3. Movimiento de base de datos
    public function queryMovimientoBd(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/query_movimiento_bd', [
                'json' => [
                    'fecha_inicial_metrica' => $request->input('fecha_inicial_metrica'),
                    'fecha_final_metrica' => $request->input('fecha_final_metrica')
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error consultando movimiento de base de datos.');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    // 4. Tráfico por Fuente
    public function queryPorFuente(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/query_por_fuente', [
                'json' => [
                    'fecha_inicial_metrica' => $request->input('fecha_inicial_metrica'),
                    'fecha_final_metrica' => $request->input('fecha_final_metrica')
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error consultando tráfico por fuente.');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    // 5. Ranking de Tenants
    public function queryRankingTenants(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/query_ranking_tenants', [
                'json' => [
                    'fecha_inicial_metrica' => $request->input('fecha_inicial_metrica'),
                    'fecha_final_metrica' => $request->input('fecha_final_metrica')
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error consultando ranking de clientes.');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    // 6. Monitoreo de Errores
    public function queryMonitoreoErrores(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/query_monitoreo_errores', [
                'json' => [
                    'fecha_inicial_metrica' => $request->input('fecha_inicial_metrica'),
                    'fecha_final_metrica' => $request->input('fecha_final_metrica')
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error consultando monitoreo de errores.');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    // 7. Rutas más utilizadas
    public function queryRutasUtilizadas(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/query_rutas_utilizadas', [
                'json' => [
                    'fecha_inicial_metrica' => $request->input('fecha_inicial_metrica'),
                    'fecha_final_metrica' => $request->input('fecha_final_metrica')
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error consultando rutas utilizadas.');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    // 8. Actividad por Horas
    public function queryActividadHoras(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/query_actividad_horas', [
                'json' => [
                    'fecha_inicial_metrica' => $request->input('fecha_inicial_metrica'),
                    'fecha_final_metrica' => $request->input('fecha_final_metrica')
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error consultando actividad horaria.');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    // 9. Borrar registros antiguos (Mantenimiento)
    public function borrarRegistros(Request $request)
    {
        try {
            $response = $this->clientApi->post($this->baseUri . 'administracion/borrar_registros', [
                'json' => [
                    // Este no requiere fechas, la API lo calcula solo
                    '_token' => $request->input('_token')
                ]
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            alert()->error('Error durante el proceso de mantenimiento de registros.');
            return back();
        }
    }
}
