<?php

namespace App\Http\Controllers\inicio_sesion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Helpers\DatabaseConnectionHelper;
use App\Http\Responsable\inicio_sesion\LoginStore;
use App\Http\Responsable\inicio_sesion\CambiarClave;
use App\Http\Responsable\inicio_sesion\RecuperarClave;
use App\Http\Responsable\inicio_sesion\RecuperarClaveUpdate;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use MetodosTrait;
    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = config('services.lumen.base_uri', env('BASE_URI'));
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    private function getLandingHeaders(): array
    {
        return [
            'X-Landing-API-Key' => config('services.lumen.landing_key'),
            'Accept'            => 'application/json',
        ];
    }

    // ======================================================================

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->checkDatabaseConnection()) {
            return view('db_conexion');
        }

        // Si el usuario ya inició sesión con tus variables
        if (session()->has('sesion_iniciada') && session('sesion_iniciada') === true) {
            return redirect()->route('home.index');
        }

        // Inicialización por defecto en caso de fallo en la API
        $planesLanding          = collect([]);
        $tiposDocumento         = collect([]);
        $planesSelect           = collect([]);
        $planesData             = collect([]);
        $tiposPagoSuscripcion   = collect([]);

        // Consultar datos para Landing y Registro sin sesión activa
        try {
            $this->initHttpClient(); // Asegura la instancia base de Guzzle

            // 1. Obtener la lista de planes para la landing (@include('layouts.planesLanding'))
            $resPlanes = $this->clientApi->get('landing/planes_landing', [
                'headers' => $this->getLandingHeaders()
            ]);
            $planesLanding = collect(json_decode($resPlanes->getBody()->getContents(), true) ?? []);

            // 2. Obtener los selects e información del formulario de registro (@include('layouts.formCrearEmpresaSuscripcionLanding'))
            $resTraits = $this->clientApi->get('landing/config_inicial_trait_landing', [
                'headers' => $this->getLandingHeaders()
            ]);
            $traitsLanding = json_decode($resTraits->getBody()->getContents(), true) ?? [];

            // Mapeo exacto de las variables necesarias para el formulario
            $tiposDocumento       = collect($traitsLanding['tipos_documento'] ?? [])->pluck('tipo_documento', 'id_tipo_documento');
            $planesSelect         = collect($traitsLanding['planes'] ?? [])->pluck('nombre_plan', 'id_plan');
            $planesData           = collect($traitsLanding['planesData'] ?? [])->keyBy('id_plan');
            $tiposPagoSuscripcion = collect($traitsLanding['tipos_pago_suscripcion'] ?? [])->pluck('tipo_pago', 'id_tipo_pago');

        } catch (Exception $e) {
            Log::error('Error cargando datos de la landing: ' . $e->getMessage());

            // dd([
            //     'Error Mensaje' => $e->getMessage(),
            //     'Linea'         => $e->getLine(),
            //     'Archivo'       => $e->getFile()
            // ]);
        }

        return view('inicio_sesion.login', compact(
            'planesLanding',
            'tiposDocumento',
            'planesSelect',
            'planesData',
            'tiposPagoSuscripcion'
        ));
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
        if (!$this->checkDatabaseConnection()) {
            return view('db_conexion');
        } else {
            return new LoginStore();
        }
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

    public function logout(Request $request)
    {
        try {
            // 1. Cerrar sesión de autenticación
            Auth::logout();

            // 2. Restaurar conexión principal
            DatabaseConnectionHelper::restaurarConexionPrincipal();

            // Olvidar variables de sesión específicas (existente)
            Session::forget([
                'id_usuario',
                'usuario',
                'id_rol',
                'sesion_iniciada'
            ]);

            // 3. Limpiar toda la sesión
            Session::flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // 4. Redirigir al login
            return redirect()->route('login')->with([
                'status' => 'Sesión cerrada correctamente'
            ]);

        } catch (Exception $e) {
            // Asegurar conexión principal incluso si falla el logout
            DatabaseConnectionHelper::restaurarConexionPrincipal();
            
            alert()->error('Ha ocurrido un error al cerrar sesión');
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    public function cambiarClave(Request $request)
    {
        if (!$this->checkDatabaseConnection())
        {
            return view('db_conexion');
        } else
        {
            $sesion = $this->validarVariablesSesion();

            if (
                empty($sesion[0]) || is_null($sesion[0]) &&
                empty($sesion[1]) || is_null($sesion[1]) &&
                empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
            {
                return redirect()->to(route('login'));
            } else
            {
                $vista = new CambiarClave();
                return $this->validarAccesos($sesion[0], 11, $vista);
            }
        }
    }

    // ======================================================================
    // ======================================================================
    
    public function recuperarClave()
    {
        if (!$this->checkDatabaseConnection())
        {
            return view('db_conexion');
        } else {
            return view('inicio_sesion.recuperar_clave');
        }
    }

    public function recuperarClaveEmail(Request $request)
    {
        if (!$this->checkDatabaseConnection()) {
            return view('db_conexion');
        } else {
            return new RecuperarClave();
        }
    }

    public function recuperarClaveLink($usuIdRecuperarClave)
    {
        if (!$this->checkDatabaseConnection())
        {
            return view('db_conexion');
        } else
        {
            return view('inicio_sesion.recuperar_clave_link', compact('usuIdRecuperarClave'));
        }
    }

    public function recuperarClaveUpdate(Request $request)
    {
        if (!$this->checkDatabaseConnection())
        {
            return view('db_conexion');
        } else
        {
            return new RecuperarClaveUpdate();
        }
    }
}  // Fin clase LoginController
