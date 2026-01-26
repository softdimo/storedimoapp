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

    protected function initHttpClient()
    {
        if (!$this->clientApi) {
            $this->baseUri = env('BASE_URI');
            $this->clientApi = new Client([
                'base_uri' => $this->baseUri,
                'timeout' => $this->apiTimeout,
                'headers' => [
                    'Accept' => 'application/json'
                ]
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

    protected $configData = null;

    public function cargarConfiguracionInicial()
    {
        // 1. Verificamos si ya tenemos los datos en memoria para evitar llamadas extra
        if ($this->configData !== null) {
            return $this->configData;
        }

        try {
            // 2. Aseguramos que el cliente HTTP esté inicializado
            $this->initHttpClient();

            // 3. Realizamos la petición (usando la ruta relativa, ya que base_uri ya está configurada)
            $response = $this->clientApi->get('config_inicial_trait');

            // 4. Asignamos el resultado a la propiedad
            $this->configData = json_decode($response->getBody()->getContents(), true);

            return $this->configData;

        } catch (Exception $e) {
            // Log del error para debugging, evita el dd() en producción
            logger()->error("Error en cargarConfiguracionInicial: " . $e->getMessage());
            
            alert()->error('Error', 'No se pudo cargar la configuración inicial Traits.');
            return null;
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

        // Para el pluck del select normal
        view()->share('planes',$this->planes());

        // Para obtener TODOS los campos del plan en un arreglo indexado por id_plan
        view()->share('planesData', $this->planesData());
    } // FIN shareBasicData()

    // =======================================================================================

    public function roles()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['roles'] ?? [])->pluck('name', 'id');
    }

    public function rolesTenant()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['rolesTenant'] ?? [])->pluck('name', 'id');
    }

    public function estados()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['estados'] ?? [])->pluck('estado', 'id_estado');
    }

    public function estadosSuscripciones()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['estados_suscripciones'] ?? [])->pluck('estado', 'id_estado');
    }

    public function tiposDocumento()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_documento'] ?? [])->pluck('tipo_documento', 'id_tipo_documento');
    }

    public function tiposDocumentoUsuario()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_documento_usuario'] ?? [])->pluck('tipo_documento', 'id_tipo_documento');
    }

    public function tiposPersona()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_persona'] ?? [])->pluck('tipo_persona', 'id_tipo_persona');
    }

    public function tiposEmpleado()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_empleado'] ?? [])->pluck('tipo_persona', 'id_tipo_persona');
    }

    public function tiposProveedor()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_proveedor'] ?? [])->pluck('tipo_persona', 'id_tipo_persona');
    }

    public function generos()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['generos'] ?? [])->pluck('genero', 'id_genero');
    }

    public function tiposBaja()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_baja'] ?? [])->pluck('tipo_baja', 'id_tipo_baja');
    }

    public function tiposPagoVentas()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_pago_ventas'] ?? [])->pluck('tipo_pago', 'id_tipo_pago');
    }

    public function tiposPagoNomina()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_pago_nomina'] ?? [])->pluck('tipo_pago', 'id_tipo_pago');
    }

    public function tiposPagoSuscripcion()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_pago_suscripcion'] ?? [])->pluck('tipo_pago', 'id_tipo_pago');
    }

    public function periodosPago()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['periodos_pago'] ?? [])->pluck('periodo_pago', 'id_periodo_pago');
    }

    public function porcentajesComision()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['porcentajes_comision'] ?? [])->pluck('porcentaje_comision', 'id_porcentaje_comision');
    }

    public function empresas()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['empresas'] ?? [])->pluck('nombre_empresa', 'id_empresa');
    }

    public function tiposBd()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_bd'] ?? [])->pluck('tipo_bd', 'id_tipo_bd');
    }

    public function usuarios()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['usuarios'] ?? [])->pluck('user', 'id_usuario');
    }

    public function tiposCliente()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['tipos_cliente'] ?? [])->pluck('tipo_persona', 'id_tipo_persona');
    }

    public function planes()
    {
        $data = $this->cargarConfiguracionInicial();
        return collect($data['planes'] ?? [])->pluck('nombre_plan', 'id_plan');
    }

    public function planesData()
    {
        $data = $this->cargarConfiguracionInicial();
        // No usamos pluck aquí porque queremos el objeto completo indexado por ID
        return collect($data['planesData'] ?? []);
    }

    // =======================================================================================

    /**
     * Genera la lista de empresas para el select de suscripciones.
     * Excluye todas las empresas con suscripción activa, excepto la actual (si se está editando).
     * * @param int|null $idEmpresaActual El ID de la empresa que se está editando (null para creación).
     * @return void
     */
    public function shareEmpresasSuscripciones(?int $idEmpresaActual = null): void
    {
        try {
            $this->initHttpClient();
            $id = $idEmpresaActual ?? 'null';
            
            $response = $this->clientApi->get("administracion/empresas_disponibles_suscripcion/{$id}");
            $data = json_decode($response->getBody()->getContents(), true);

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
            view()->share('permisos', []);
            return back()->with('error', 'Error obteniendo permisos del sistema');
        }
    }

    protected function getPermisosFromApi()
    {
        $cacheKey = 'permisos_view_share_' . session('id_usuario');
        
        return Cache::remember($cacheKey, now()->addMinutes(1), function () {
            $response = $this->clientApi->get('administracion/permisos_view_share_trait');
            return json_decode($response->getBody()->getContents());
        });
    }

    public function permisos()
    {
        try
        {
            $this->initHttpClient();
            $cacheKey = 'permisos_list_' . session('id_usuario');

            return Cache::remember($cacheKey, now()->addMinutes(1), function () {
                $response = $this->clientApi->get('administracion/permisos_trait');
                return json_decode($response->getBody()->getContents());
            });

        } catch (RequestException $e)
        {
            return [];
        }
    }

    public function permisosPorUsuario($idUsuario)
    {
        try
        {
            $this->initHttpClient();
            $cacheKey = 'permisos_usuario_' . $idUsuario;

            return Cache::remember($cacheKey, now()->addMinutes(1), function () use ($idUsuario) {
                $response = $this->clientApi->get("administracion/permisos_por_usuario_trait/{$idUsuario}", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . session('api_token')
                    ]
                ]);
                return json_decode($response->getBody()->getContents());
            });

        } catch (RequestException $e) {
            return [];
        }
    }

    public function validarAccesos($usuarioId, $permissionId, $vista, $infCodigo = null)
    {
        try
        {
            $permisosUsuario = $this->permisosPorUsuario($usuarioId);

            if (empty($permisosUsuario))
            {
                return view('errors.403')->with('error', 'No se encontraron permisos');
            }

            if (!in_array($permissionId, $permisosUsuario)) {
                return view('errors.403');
            }

            // Si es una vista simple
            if (is_string($vista) && is_null($infCodigo))
            {
                return view($vista);
            }

            // Si es una vista de informe
            if ($vista === 'informe_gerencial' && $infCodigo)
            {
                try
                {
                    // Realiza la solicitud POST a la API
                    $client = new Client(['base_uri' => env('BASE_URI')]);
        
                    $response = $client->post('administracion/informe_gerencial', [
                            'json' => [
                                'infCodigo' => $infCodigo,
                                'id_audit' => session('id_usuario')
                            ]
                        ]
                    );

                    $respuesta = json_decode($response->getBody()->getContents(), true);
                    
                    $campos = json_decode(json_encode($respuesta['campos']));
                    $informe = json_decode(json_encode($respuesta['informe']));

                    return view('informes.informe', compact('campos', 'informe'));

                } catch (Exception $e)
                {
                    alert()->error('Error en el informe gerencial');
                    return redirect()->route('home');
                }
            }

            // Si la vista es una respuesta diferente (por ejemplo, un redirect)
            return $vista;

        } catch (Exception $e)
        {
            return view('errors.403')->with('error', 'Error validando permisos');
        }
    }
}
