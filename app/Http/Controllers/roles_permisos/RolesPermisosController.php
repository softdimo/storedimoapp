<?php

namespace App\Http\Controllers\roles_permisos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
use Exception;
use App\Http\Responsable\roles_permisos\RolesPermisos;

class RolesPermisosController extends Controller
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

    public function guardarRol(Request $request)
    {
        try
        {
            if (!$this->checkDatabaseConnection())
            {
                return view('db_conexion');
            } else
            {
                $sesion = $this->validarVariablesSesion();
    
                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    return new RolesPermisos();
                }
            }
            
        } catch (Exception $e)
        {
            alert()->error("Ha ocurrido un error creando el rol!");
            return back();
        }
    }

    public function guardarPermiso(Request $request)
    {
        try
        {
            if (!$this->checkDatabaseConnection())
            {
                return view('db_conexion');
            } else
            {
                $sesion = $this->validarVariablesSesion();
    
                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    $rolesPermisos = new RolesPermisos();
                    return $rolesPermisos->crearPermiso($request);
                }
            }
            
        } catch (Exception $e)
        {
            alert()->error("Ha ocurrido un error creando el rol!");
            return back();
        }
    }

    public function consultarPermisosPorUsuario(Request $request)
    {
        try
        {
            if (!$this->checkDatabaseConnection())
            {
                return view('db_conexion');
            } else
            {
                $sesion = $this->validarVariablesSesion();
    
                if (empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else
                {
                    $rolesPermisos = new RolesPermisos();
                    return $rolesPermisos->consultarPermisosPorUsuario($request);
                }
            }
            
        } catch (Exception $e)
        {
            return response()->json("error_exception");
        }
    }
}
