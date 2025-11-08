<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;

class HomeController extends Controller
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

                return view('home.index', compact('ventaDiaMes','entradaDiaMes'));
   
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
}
