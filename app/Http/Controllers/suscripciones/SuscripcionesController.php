<?php

namespace App\Http\Controllers\suscripciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Http\Responsable\suscripciones\SuscripcionIndex;
use App\Http\Responsable\suscripciones\SuscripcionStore;
use App\Http\Responsable\suscripciones\SuscripcionEdit;
use App\Http\Responsable\suscripciones\SuscripcionUpdate;
use App\Http\Responsable\suscripciones\RenovarSuscripcion;
use App\Models\Suscripcion;
use App\Models\Empresa;
use App\Models\Usuario;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;

class SuscripcionesController extends Controller
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

    /* Helper privado para obtener las cabeceras estándar con JWT */
    private function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . session('api_jwt_token'),
            'Accept'        => 'application/json',
        ];
    }
    
    public function index()
    {
        try
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
                    $rolId = $sesion[2];
                    $usuarioId = $sesion[0];

                    $vista = new SuscripcionIndex($rolId, $usuarioId);
                    return $this->validarAccesos($sesion[0], 68, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Index Suscripciones!");
            return redirect()->to(route('login'));
        }
    }

    public function create()
    {
        try {
            if (!$this->checkDatabaseConnection())
            {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();

                if (
                    empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3]
                ) {
                    return redirect()->to(route('login'));
                } else
                {
                    $rolId = $sesion[2];

                    if($rolId == 3)
                    {
                        // Llama al método del trait para cargar empresas disponibles
                        $this->shareEmpresasSuscripciones(null);
    
                        view()->share('rolId', $rolId);
                        $vista = 'suscripciones.create';
                        return $this->validarAccesos($sesion[0], 69, $vista);
                    }
                    else
                    {
                        return view('errors.403');
                    }

                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Create Suscripciones!");
            return redirect()->to(route('login'));
        }
    }

    public function store(Request $request)
    {
        try
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
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3]
                ) {
                    return redirect()->to(route('login'));
                } else
                {
                    $vista = new SuscripcionStore();
                    return $this->validarAccesos($sesion[0], 70, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Store Usuario!");
            return redirect()->to(route('login'));
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $idSuscripcion)
    {
        try
        {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {
                $sesion = $this->validarVariablesSesion();

                if (
                    empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3]
                ) {
                    return redirect()->to(route('login'));
                } else
                {
                    // 1. Obtener el ID de la empresa actualmente suscrita.
                    // Nota: Asumimos que $idSuscripcion existe y es válido.
                    $suscripcion = Suscripcion::select('id_empresa_suscrita')->find($idSuscripcion);
                    $idEmpresaActual = $suscripcion ? $suscripcion->id_empresa_suscrita : null;

                    // 2. Llama al método del trait pasando el ID de la empresa actual.
                    $this->shareEmpresasSuscripciones($idEmpresaActual);
                    // ==============================

                    $vista = new SuscripcionEdit($idSuscripcion);
                    return $this->validarAccesos($sesion[0], 71, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Edit Usuario!");
            return redirect()->to(route('login'));
        }
    }

    public function update(Request $request, $idSuscripcion)
    {
        try
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
                    $vista = new SuscripcionUpdate($idSuscripcion);
                    return $this->validarAccesos($sesion[0], 72, $vista);
                }
            }
        } catch (Exception $e)
        {
            alert()->error("Exception Update Usuario!");
            return redirect()->to(route('login'));
        }
    }

    public function destroy($id)
    {
        //
    }

    public function renovarSuscripcion()
    {
        try
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
                    $empresa = Usuario::with('empresa')->find($sesion[0]);
                    view()->share('empresa', $empresa);
                    $vista = new RenovarSuscripcion();
                    return $this->validarAccesos($sesion[0], 86, $vista);
                }
            }
            
        } catch (Exception $e)
        {
            alert()->error("Ha ocurrido un error cargando el formulario, contácte a soporte!");
            return redirect()->to(route('login'));
        }
    }

    public function guardarRenovacion(Request $request)
    {
        try
        {
            $suscripcionUpdate = new SuscripcionUpdate($request->id_plan_suscrito);
            return $suscripcionUpdate->guardarRenovacion($request);
            
        } catch (\Throwable $e)
        {
            alert()->error("Ha ocurrido un error guardando la renovación, contácte a soporte!");
            return back();
        }

    }
}
