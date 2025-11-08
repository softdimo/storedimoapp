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

class LoginController extends Controller
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

    // ======================================================================

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->checkDatabaseConnection())
        {
            return view('db_conexion');
        }

        // Si el usuario ya inició sesión con tus variables
        if (session()->has('sesion_iniciada') && session('sesion_iniciada') === true) {
            return redirect()->route('home.index');
        }
        
        return view('inicio_sesion.login');
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

    // ======================================================================
    // ======================================================================

    public function recuperarClaveEmail(Request $request)
    {
        if (!$this->checkDatabaseConnection()) {
            return view('db_conexion');
        } else {
            return new RecuperarClave();
        }
    }

    // ======================================================================
    // ======================================================================

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

    // ======================================================================
    // ======================================================================

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
