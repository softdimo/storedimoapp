<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Http\Responsable\usuarios\UsuarioIndex;
use App\Http\Responsable\usuarios\UsuarioStore;
use App\Http\Responsable\usuarios\UsuarioUpdate;
use App\Http\Responsable\usuarios\UsuarioEdit;
use App\Http\Responsable\usuarios\CambiarClaveUsuario;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
use Illuminate\Validation\ValidationException;

class UsuariosController extends Controller
{
    use MetodosTrait;
    // protected $baseUri;
    // protected $clientApi;

    public function __construct()
    {
        // $this->shareData();
        $this->middleware(function ($request, $next) {
            $this->shareData(); // 🟢 Se ejecuta con la sesión y JWT ya cargados
            return $next($request);
        });
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // ======================================================================
    // ======================================================================

    /* Helper privado para obtener las cabeceras estándar con JWT */
    private function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . session('api_jwt_token'),
            'Accept'        => 'application/json',
        ];
    }

    // ======================================================================
    // ======================================================================
    
    public function index()
    {
        try {
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
                } else {
                    $vista = new UsuarioIndex();
                    return $this->validarAccesos($sesion[0], 3, $vista);
                }
            }
        } catch (Exception $e) {
            logger()->error("Exception Index Usuario: " . $e->getMessage());
            alert()->error("Exception Index Usuario!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================
    // ======================================================================

    public function create()
    {
        try {
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
                } else {
                    $vista = 'usuarios.create';
                    return $this->validarAccesos($sesion[0], 2, $vista);
                }
            }
        } catch (Exception $e) {
            logger()->error("Exception Create Usuario: " . $e->getMessage());
            alert()->error("Exception Create Usuario!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================
    // ======================================================================

    public function store(Request $request)
    {
        try {
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
                } else {
                    $vista = new UsuarioStore();
                    return $this->validarAccesos($sesion[0], 9, $vista);
                }
            }
        } catch (Exception $e) {
            logger()->error("Exception Store Usuario: " . $e->getMessage());
            alert()->error("Exception Store Usuario!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================
    // ======================================================================

    public function show($id)
    {
        //comment
    }

    // ======================================================================
    // ======================================================================

    public function edit(Request $request, $idUsuario)
    {
        try {
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
                } else {
                    $vista = new UsuarioEdit($idUsuario);
                    return $this->validarAccesos($sesion[0], 10, $vista);
                }
            }
        } catch (Exception $e) {
            logger()->error("Exception Edit Usuario: " . $e->getMessage());
            alert()->error("Exception Edit Usuario!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================
    // ======================================================================

    public function update(Request $request, $idUsuario)
    {
        try {
            if (!$this->checkDatabaseConnection()) {
                return view('db_conexion');
            } else {

                $sesion = $this->validarVariablesSesion();

                if (
                    empty($sesion[0]) || is_null($sesion[0]) &&
                    empty($sesion[1]) || is_null($sesion[1]) &&
                    empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
                {
                    return redirect()->to(route('login'));
                } else {
                    $vista = new UsuarioUpdate();
                    return $this->validarAccesos($sesion[0], 10, $vista);
                }
            }
        } catch (Exception $e) {
            logger()->error("Exception Update Usuario: " . $e->getMessage());
            alert()->error("Exception Update Usuario!");
            return redirect()->to(route('login'));
        }
    }

    // ======================================================================
    // ======================================================================

    public function destroy($id)
    {
        //comment
    }

    // public function listarClientes()
    // {
    //     try {
    //         if (!$this->checkDatabaseConnection()) {
    //             return view('db_conexion');
    //         } else {
    //             $sesion = $this->validarVariablesSesion();

    //             if (
    //                 empty($sesion[0]) || is_null($sesion[0]) &&
    //                 empty($sesion[1]) || is_null($sesion[1]) &&
    //                 empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
    //             {
    //                 return redirect()->to(route('login'));
    //             } else {
    //                 $vista = 'personas.listar_clientes';
    //                 return $this->validarAccesos($sesion[0], 1, $vista);
    //             }
    //         }
    //     } catch (Exception $e) {
    //         logger()->error("Exception Listar Clientes: " . $e->getMessage());
    //         alert()->error("Exception Store Usuario!");
    //         return redirect()->to(route('login'));
    //     }
    // }

    public function queryUsuarioUpdate($idUsuario)
    {
        try {
            // $response = $this->clientApi->post($this->baseUri . 'administracion/query_usuario_update/' . $idUsuario, ['json' => []]);
            $response = $this->clientApi->post('administracion/query_usuario_update/' . $idUsuario, [
                'headers' => $this->getHeaders(),
                'json'    => [],
                // 'timeout' => 5.0
            ]);
            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            logger()->error("Error en queryUsuarioUpdate: " . $e->getMessage());
            alert()->error("Error Exception!");
            return back();
        }
    }

    // ======================================================================
    // ======================================================================

    /**
     * Valida la estructura del correo recibido y consulta una API externa
     * para verificar si el correo ya está registrado.
     *
     * @param Request $request Contiene el email a validar
     * @return \Illuminate\Http\JsonResponse Retorna JSON indicando si el email es válido o ya está en uso
     */
    public function emailValidator(Request $request)
    {
        try {
            $request->validate([
                'email' => [
                    'required',
                    'string',
                    'email:rfc,dns',
                    'max:255'
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'valido' => false,
                'error' => 'El correo no tiene un formato válido.'
            ], 422);
        }

        try {
            // $response = $this->clientApi->post($this->baseUri . 'administracion/validar_email', [
            $response = $this->clientApi->post('administracion/validar_email', [
                'headers' => $this->getHeaders(),
                'json' => [
                    'email' => $request->input('email')
                ],
                'timeout' => 5.0
            ]);
            return response()->json(json_decode($response->getBody()->getContents(), true));

        } catch (\Exception $e) {
            logger()->error("Error en emailValidator: " . $e->getMessage());
            return response()->json([
                'error' => 'No se pudo validar el email',
                'valido' => false
            ], 500);
        }
    }

    // ======================================================================
    // ======================================================================

    /**
     * Valida que el campo de identificación sea numérico y dentro de un rango de longitud,
     * luego consulta una API externa para verificar si ya está registrada.
     *
     * @param Request $request Contiene el campo 'identificacion' a validar
     * @return \Illuminate\Http\JsonResponse Retorna JSON indicando si la identificación es válida o ya está registrada
     */
    public function identificationValidator(Request $request)
    {
        try {
            $request->validate([
                'identificacion' => [
                    'required',
                    'string',
                    'min:6',
                    'max:15'
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'valido' => false,
                'error' => 'La identificación no tiene un formato válido.'
            ], 422);
        }

        try {
            // $response = $this->clientApi->post($this->baseUri . 'administracion/validar_identificacion', [
            $response = $this->clientApi->post('administracion/validar_identificacion', [
                'headers' => $this->getHeaders(),
                'json' => [
                    'identificacion' => $request->input('identificacion')
                ],
                // 'timeout' => 5.0
            ]);
            return response()->json(json_decode($response->getBody()->getContents(), true));

        } catch (\Exception $e) {
            logger()->error("Error en identificationValidator: " . $e->getMessage());
            return response()->json([
                'error' => 'No se pudo validar la identificación',
                'valido' => false
            ], 500);
        }
    }

    // ======================================================================
    // ======================================================================

    public function cambiarClaveUsuario(Request $request)
    {
        if (!$this->checkDatabaseConnection()) {
            return view('db_conexion');
        } else {
            $sesion = $this->validarVariablesSesion();

            if (
                empty($sesion[0]) || is_null($sesion[0]) &&
                empty($sesion[1]) || is_null($sesion[1]) &&
                empty($sesion[2]) || is_null($sesion[2]) && !$sesion[3])
            {
                return redirect()->to(route('login'));
            } else {
                $vista = new CambiarClaveUsuario();
                return $this->validarAccesos($sesion[0], 11, $vista);
            }
        }
    }

    // ======================================================================
    // ======================================================================
}
