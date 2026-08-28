<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;
use Illuminate\Support\Facades\Cache;

trait MetodosTrait
{
    protected $baseUri;
    protected $clientApi;
    protected $apiTimeout = 10.0; // Timeout en segundos
    protected $configData = null;

    // protected function initHttpClient()
    // {
    //     if (!$this->clientApi) {
    //         $this->baseUri = env('BASE_URI');
    //         $this->clientApi = new Client([
    //             'base_uri' => $this->baseUri,
    //             'timeout' => $this->apiTimeout,
    //             'headers' => [
    //                 'Accept' => 'application/json'
    //             ]
    //         ]);
    //     }
    // }

    protected function initHttpClient()
    {
        if (!$this->clientApi) {
            $this->baseUri = env('BASE_URI');

            $headers = [
                'Accept' => 'application/json'
            ];

            // Inyección global del Token JWT si existe en la sesión
            $jwtToken = session('api_jwt_token');
            if ($jwtToken) {
                $headers['Authorization'] = 'Bearer ' . $jwtToken;
            }

            $this->clientApi = new Client([
                'base_uri' => $this->baseUri,
                'timeout'  => $this->apiTimeout,
                'headers'  => $headers
            ]);
        }
    }

    public function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validarVariablesSesion()
    {
        return [
            session('id_usuario'),
            session('usuario'),
            session('id_rol'),
            session('sesion_iniciada')
        ];
    }

    public function quitarCaracteresEspeciales($cadena)
    {
        $no_permitidas = [
            'á', 'é', 'í', 'ó', 'ú',
            'Á', 'É', 'Í', 'Ó', 'Ú',
            'ñ', 'À', 'Ã', 'Ì', 'Ò',
            'Ù', 'Ã™', 'Ã', 'Ã¨', 'Ã¬',
            'Ã²', 'Ã¹', 'ç', 'Ç', 'Ã¢',
            'ê', 'Ã®', 'Ã´', 'Ã»', 'Ã‚',
            'ÃŠ', 'ÃŽ', 'Ã"', 'Ã›', 'ü',
            'Ã¶', 'Ã–', 'Ã¯', 'Ã¤', '«',
            'Ò', 'Ã', 'Ã„', 'Ã‹', 'ñ',
            'Ñ', '*'
        ];

        $permitidas = [
            'a', 'e', 'i', 'o', 'u',
            'A', 'E', 'I', 'O', 'U',
            'n', 'N', 'A', 'E', 'I',
            'O', 'U', 'a', 'e', 'i',
            'o', 'u', 'c', 'C', 'a',
            'e', 'i', 'o', 'u', 'A',
            'E', 'I', 'O', 'U', 'u',
            'o', 'O', 'i', 'a', 'e',
            'U', 'I', 'A', 'E', 'n',
            'N', ''
        ];

        return str_replace($no_permitidas, $permitidas, $cadena);
    }

    // ======================================

    public function cargarConfiguracionInicial()
    {
        // 1. Evita llamadas duplicadas si ya se consultó en el mismo request (exitoso o fallido)
        if ($this->configData !== null) {
            return $this->configData;
        }

        try {
            // Validar existencia previa de token para no perder tiempo en petición HTTP fallida
            if (!session('api_jwt_token')) {
                $this->configData = [];
                return $this->configData;
            }

            $this->initHttpClient();

            // Timeout ajustado para este endpoint específico
            $response = $this->clientApi->get('administracion/config_inicial_trait', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('api_jwt_token'),
                    'Accept'        => 'application/json',
                ],
                // 'timeout' => 5.0
            ]);

            $this->configData = json_decode($response->getBody()->getContents(), true) ?? [];
            return $this->configData;

        } catch (Exception $e) {
            logger()->error("Error en cargarConfiguracionInicial: " . $e->getMessage());
            // Guardamos array vacío para detener reintentos en este mismo ciclo
            $this->configData = [];
            return $this->configData;
        }
    }

    // ======================================

    public function shareData()
    {
        // Compartir datos básicos que no requieren la API
        $this->shareBasicData();
        
        // Compartir permisos desde la API
        $this->sharePermissionsData();
    }

    protected function shareBasicData()
    {
        view()->share('roles',$this->roles());
        view()->share('rolesTenant',$this->rolesTenant());
        view()->share('estados',$this->estados());
        view()->share('estados_suscripciones',$this->estadosSuscripciones());
        view()->share('tipos_documento',$this->tiposDocumento());
        view()->share('tipos_documento_usuario',$this->tiposDocumentoUsuario());
        view()->share('tipos_persona',$this->tiposPersona());
        view()->share('tipos_empleado',$this->tiposEmpleado());
        view()->share('tipos_proveedor',$this->tiposProveedor());
        view()->share('generos',$this->generos());
        view()->share('tipos_baja',$this->tiposBaja());
        view()->share('tipos_pago_ventas',$this->tiposPagoVentas());
        view()->share('tipos_pago_nomina',$this->tiposPagoNomina());
        view()->share('tipos_pago_suscripcion',$this->tiposPagoSuscripcion());
        view()->share('periodos_pago',$this->periodosPago());
        view()->share('porcentajes_comision',$this->porcentajesComision());
        view()->share('empresas',$this->empresas());
        view()->share('tipos_bd',$this->tiposBd());
        view()->share('usuarios',$this->usuarios());
        view()->share('tipos_cliente',$this->tiposCliente());
        view()->share('planes',$this->planes()); // Para el pluck del select normal
        view()->share('planesData', $this->planesData()); // Para obtener TODOS los campos del plan en un arreglo indexado por id_plan
        view()->share('tiposMetrica', $this->tiposMetrica());
    } // FIN shareBasicData()

    // =======================================================================================

    public function roles() { return collect($this->cargarConfiguracionInicial()['roles'] ?? [])->pluck('name', 'id'); }
    public function rolesTenant() { return collect($this->cargarConfiguracionInicial()['rolesTenant'] ?? [])->pluck('name', 'id'); }
    public function estados() { return collect($this->cargarConfiguracionInicial()['estados'] ?? [])->pluck('estado', 'id_estado'); }
    public function estadosSuscripciones() { return collect($this->cargarConfiguracionInicial()['estados_suscripciones'] ?? [])->pluck('estado', 'id_estado'); }
    public function tiposDocumento() { return collect($this->cargarConfiguracionInicial()['tipos_documento'] ?? [])->pluck('tipo_documento', 'id_tipo_documento'); }
    public function tiposDocumentoUsuario() { return collect($this->cargarConfiguracionInicial()['tipos_documento_usuario'] ?? [])->pluck('tipo_documento', 'id_tipo_documento'); }
    public function tiposPersona() { return collect($this->cargarConfiguracionInicial()['tipos_persona'] ?? [])->pluck('tipo_persona', 'id_tipo_persona'); }
    public function tiposEmpleado() { return collect($this->cargarConfiguracionInicial()['tipos_empleado'] ?? [])->pluck('tipo_persona', 'id_tipo_persona'); }
    public function tiposProveedor() { return collect($this->cargarConfiguracionInicial()['tipos_proveedor'] ?? [])->pluck('tipo_persona', 'id_tipo_persona'); }
    public function generos() { return collect($this->cargarConfiguracionInicial()['generos'] ?? [])->pluck('genero', 'id_genero'); }
    public function tiposBaja() { return collect($this->cargarConfiguracionInicial()['tipos_baja'] ?? [])->pluck('tipo_baja', 'id_tipo_baja'); }
    public function tiposPagoVentas() { return collect($this->cargarConfiguracionInicial()['tipos_pago_ventas'] ?? [])->pluck('tipo_pago', 'id_tipo_pago'); }
    public function tiposPagoNomina() { return collect($this->cargarConfiguracionInicial()['tipos_pago_nomina'] ?? [])->pluck('tipo_pago', 'id_tipo_pago'); }
    public function tiposPagoSuscripcion() { return collect($this->cargarConfiguracionInicial()['tipos_pago_suscripcion'] ?? [])->pluck('tipo_pago', 'id_tipo_pago'); }
    public function periodosPago() { return collect($this->cargarConfiguracionInicial()['periodos_pago'] ?? [])->pluck('periodo_pago', 'id_periodo_pago'); }
    public function porcentajesComision() { return collect($this->cargarConfiguracionInicial()['porcentajes_comision'] ?? [])->pluck('porcentaje_comision', 'id_porcentaje_comision'); }
    public function empresas() { return collect($this->cargarConfiguracionInicial()['empresas'] ?? [])->pluck('nombre_empresa', 'id_empresa'); }
    public function tiposBd() { return collect($this->cargarConfiguracionInicial()['tipos_bd'] ?? [])->pluck('tipo_bd', 'id_tipo_bd'); }
    public function usuarios() { return collect($this->cargarConfiguracionInicial()['usuarios'] ?? [])->pluck('user', 'id_usuario'); }
    public function tiposCliente() { return collect($this->cargarConfiguracionInicial()['tipos_cliente'] ?? [])->pluck('tipo_persona', 'id_tipo_persona'); }
    public function planes() { return collect($this->cargarConfiguracionInicial()['planes'] ?? [])->pluck('nombre_plan', 'id_plan'); }
    public function planesData() { return collect($this->cargarConfiguracionInicial()['planesData'] ?? []); }
    public function tiposMetrica() { return collect($this->cargarConfiguracionInicial()['tiposMetrica'] ?? [])->pluck('tipo_metrica', 'id_tipo_metrica'); }

    // =======================================================================================

    /**
     * Genera la lista de empresas para el select de suscripciones.
     * Excluye todas las empresas con suscripción activa, excepto la actual (si se está editando).
     * * @param int|null $idEmpresaActual El ID de la empresa que se está editando (null para creación).
     * @return void
     */
    public function shareEmpresasSuscripciones(?int $idEmpresaActual = null): void
    {
        // Validar token de sesión antes de realizar la petición HTTP
        if (!session('api_jwt_token')) {
            view()->share('empresas_suscripciones', collect([]));
            return;
        }

        try {
            $this->initHttpClient();
            $id = $idEmpresaActual ?? 'null';
            
            // $response = $this->clientApi->get("administracion/empresas_disponibles_suscripcion/{$id}");
            $response = $this->clientApi->get("administracion/empresas_disponibles_suscripcion/{$id}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('api_jwt_token'),
                    'Accept'        => 'application/json',
                ],
                // 'timeout' => 5.0
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            // $data = json_decode($response->getBody()->getContents(), true) ?? [];

            // El pluck se hace aquí sobre la colección final que ya trae la unión hecha desde la API
            $empresasDisponibles = collect($data)->pluck('nombre_empresa', 'id_empresa');
            view()->share('empresas_suscripciones', $empresasDisponibles);
            
        } catch (Exception $e) {
            logger()->error("Error en shareEmpresasSuscripciones: " . $e->getMessage());
            view()->share('empresas_suscripciones', collect([]));
        }
    }

    // =======================================================================================

    protected function sharePermissionsData()
    {
        try {
            $this->initHttpClient();
            $permisos = $this->getPermisosFromApi();
            view()->share('permisos', $permisos);
            view()->share('permisosAsignados', []);

        } catch (RequestException $e) {
            logger()->error("Error en sharePermissionsData: " . $e->getMessage());
            view()->share('permisos', []);
            return back()->with('error', 'Error obteniendo permisos del sistema');
        }
    }

    protected function getPermisosFromApi()
    {
        $idUsuario = session('id_usuario');
        $jwtToken  = session('api_jwt_token');

        // Si no hay sesión o token, evitamos la llamada HTTP y retornamos un array/objeto vacío
        if (!$idUsuario || !$jwtToken) {
            return [];
        }

        // $cacheKey = 'permisos_view_share_' . session('id_usuario');
        $cacheKey = 'permisos_view_share_' . $idUsuario;
        
        // return Cache::remember($cacheKey, now()->addMinutes(1), function () {
        //     $response = $this->clientApi->get('administracion/permisos_view_share_trait');
        //     return json_decode($response->getBody()->getContents());
        // });

        return Cache::remember($cacheKey, now()->addMinutes(1), function () use ($jwtToken) {
            try {
                // Nos aseguramos de tener la instancia del cliente lista
                $this->initHttpClient();

                // Pasamos explícitamente el encabezado Authorization
                $response = $this->clientApi->get('administracion/permisos_view_share_trait', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwtToken,
                        'Accept'        => 'application/json',
                    ],
                    'timeout' => 5.0, // Timeout para prevenir bloqueos en la vista
                ]);

                return json_decode($response->getBody()->getContents());

            } catch (\Exception $e) {
                logger()->error("Error obteniendo permisos en getPermisosFromApi: " . $e->getMessage());
                return []; // Retorna un array vacío en caso de falla para no romper la app
            }
        });
    }

    // public function permisos()
    // {
    //     try
    //     {
    //         $this->initHttpClient();
    //         $cacheKey = 'permisos_list_' . session('id_usuario');

    //         return Cache::remember($cacheKey, now()->addMinutes(1), function () {
    //             $response = $this->clientApi->get('administracion/permisos_trait');
    //             return json_decode($response->getBody()->getContents());
    //         });

    //     } catch (RequestException $e) {
    //         logger()->error("Error en permisos: " . $e->getMessage());
    //         return [];
    //     }
    // }

    public function permisos()
    {
        $idUsuario = session('id_usuario');
        $jwtToken  = session('api_jwt_token');

        // Validación preventiva
        if (!$idUsuario || !$jwtToken) {
            return [];
        }

        try {
            $this->initHttpClient();
            $cacheKey = 'permisos_list_' . $idUsuario;

            return Cache::remember($cacheKey, now()->addMinutes(1), function () use ($jwtToken) {
                $response = $this->clientApi->get('administracion/permisos_trait', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwtToken, // <--- JWT Inyectado
                        'Accept'        => 'application/json',
                    ],
                    'timeout' => 5.0
                ]);

                return json_decode($response->getBody()->getContents());
            });

        } catch (RequestException $e) {
            logger()->error("Error en permisos: " . $e->getMessage());
            return [];
        }
    }

    public function permisosPorUsuario($idUsuario)
    {
        $jwtToken = session('api_jwt_token');

        // Si no hay token de sesión, evitamos hacer la consulta a la API
        if (!$jwtToken) {
            return [];
        }

        try {
            $this->initHttpClient();
            $cacheKey = 'permisos_usuario_' . $idUsuario;

            // return Cache::remember($cacheKey, now()->addMinutes(1), function () use ($idUsuario) {
            //     $response = $this->clientApi->get("administracion/permisos_por_usuario_trait/{$idUsuario}");
            //     return json_decode($response->getBody()->getContents());
            // });

            return Cache::remember($cacheKey, now()->addMinutes(1), function () use ($idUsuario, $jwtToken) {
                $response = $this->clientApi->get("administracion/permisos_por_usuario_trait/{$idUsuario}", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $jwtToken, // <--- JWT Inyectado
                        'Accept'        => 'application/json',
                    ],
                    'timeout' => 5.0
                ]);

                return json_decode($response->getBody()->getContents());
            });

        } catch (RequestException $e) {
            logger()->error("Error en permisosPorUsuario: " . $e->getMessage());
            return [];
        }
    }

    public function validarAccesos($usuarioId, $permissionId, $vista, $infCodigo = null)
    {
        try {
            $permisosUsuario = $this->permisosPorUsuario($usuarioId);

            if (empty($permisosUsuario)) {
                return view('errors.403')->with('error', 'No se encontraron permisos');
            }

            // if (!in_array($permissionId, $permisosUsuario)) {
            //     return view('errors.403');
            // }

            if (!in_array($permissionId, (array) $permisosUsuario)) {
                return view('errors.403');
            }

            // Si es una vista simple
            if (is_string($vista) && is_null($infCodigo)) {
                return view($vista);
            }

            // Si es una vista de informe
            if ($vista === 'informe_gerencial' && $infCodigo) {
                try {
                    $this->initHttpClient(); // Uso del cliente centralizado con JWT

                    // Realiza la solicitud POST a la API
                    // $client = new Client(['base_uri' => env('BASE_URI')]);
        
                    // $response = $client->post('administracion/informe_gerencial', [
                    $response = $this->clientApi->post('administracion/informe_gerencial', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . session('api_jwt_token'),
                            'Accept'        => 'application/json',
                        ],
                        'json' => [
                            'infCodigo' => $infCodigo,
                            'id_audit' => session('id_usuario')
                        ],
                        // 'timeout' => 5.0
                    ]);

                    $respuesta = json_decode($response->getBody()->getContents(), true);
                    
                    $campos = json_decode(json_encode($respuesta['campos']));
                    $informe = json_decode(json_encode($respuesta['informe']));

                    return view('informes.informe', compact('campos', 'informe'));

                } catch (Exception $e) {
                    logger()->error("Error en informe gerencial: " . $e->getMessage());
                    alert()->error('Error en el informe gerencial');
                    return redirect()->route('home');
                }
            }

            // Si la vista es una respuesta diferente
            return $vista;

        } catch (Exception $e) {
            logger()->error("Error en validarAccesos: " . $e->getMessage());
            return view('errors.403')->with('error', 'Error validando permisos');
        }
    }
}
