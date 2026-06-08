<?php

namespace App\Http\Responsable\empresa_suscripcion;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Crypt;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmpresaSuscripcionStore implements Responsable
{
    use MetodosTrait;

    protected $baseUri;
    protected $clientApi;

    public function __construct()
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
    }

    // ===================================================================
    // ===================================================================

    public function toResponse($request)
    {
        $idTipoDocumento = request('id_tipo_documento', null);
        $nitEmpresa = request('nit_empresa', null);
        $identEmpresaNatural = request('ident_empresa_natural', null);
        $nombreEmpresa = request('nombre_empresa', null);
        $telefonoEmpresa = request('telefono_empresa', null);
        $celularEmpresa = request('celular_empresa');
        $emailEmpresa = request('email_empresa');
        $direccionEmpresa = request('direccion_empresa');
        $idTipoBd = 1;
        $dbHost = Crypt::encrypt('localhost');
        $idEstado = 13;

        // ========================================================

        $logoEmpresaBase64 = null;

        if ($request->hasFile('logo_empresa')) {
            $logoEmpresa = $request->file('logo_empresa');

            if ($logoEmpresa->isValid()) {
                $tiposPermitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
                $tipoMime = $logoEmpresa->getMimeType();

                if (!in_array($tipoMime, $tiposPermitidos)) {
                    alert()->error('Error', 'El tipo de imagen no es válido. Solo se permiten JPG, JPEG, PNG o WEBP.');
                    return back();
                }

                // Validación de tamaño (2 MB = 2048 KB)
                $tamanioMaximoKB = 2048;
                $tamanioArchivoKB = $logoEmpresa->getSize() / 1024;

                if ($tamanioArchivoKB > $tamanioMaximoKB) {
                    alert()->error('Error', 'La imagen excede el tamaño máximo permitido de 2 MB.');
                    return back();
                }

                // Codificación base64
                $contenido = file_get_contents($logoEmpresa);
                $logoEmpresaBase64 = 'data:' . $logoEmpresa->getMimeType() . ';base64,' . base64_encode($contenido);
            }
        }

        // ========================================================

        $consultarEmpresa = $this->consultarEmpresa($nitEmpresa, $nombreEmpresa);
        
        try {
            if (isset($consultarEmpresa) && !is_null($consultarEmpresa) && !empty($consultarEmpresa)) {
                alert()->warning('Cuidado', 'Empresa existente');
                return redirect()->route('home.index')->withInput();
            }
            
            // $reqEmpresaStore = $this->getHttpClient()->post('administracion/empresa_store', [
            $reqEmpresaStore = $this->clientApi->post($this->baseUri.'administracion/empresa_store', [
                'json' => [
                    'id_tipo_documento' => $idTipoDocumento,
                    'nit_empresa' => $nitEmpresa,
                    'ident_empresa_natural' => $identEmpresaNatural,
                    'nombre_empresa' => $nombreEmpresa,
                    'telefono_empresa' => $telefonoEmpresa,
                    'celular_empresa' => $celularEmpresa,
                    'email_empresa' => $emailEmpresa,
                    'direccion_empresa' => $direccionEmpresa,
                    'id_tipo_bd' => $idTipoBd,
                    'db_host' => $dbHost,
                    'logo_empresa' => $logoEmpresaBase64,
                    'id_estado' => $idEstado,
                ]
            ]);
            $resEmpresaStore = json_decode($reqEmpresaStore->getBody()->getContents());

            if (!isset($resEmpresaStore->success) || !$resEmpresaStore->success) {
                alert()->error('Error', 'No fue posible crear la empresa.');
                return back();
            }

            // FIN Store EMPRESA
            // ===================================================================
            // ===================================================================

            // INICIO Store SUSCIPCIÓN EMPRESA
            if (isset($resEmpresaStore->success) && $resEmpresaStore->success) {
                $idEmpresaRecienCreada = $resEmpresaStore->empresa->id_empresa;
                $idEmpresaSuscrita = $idEmpresaRecienCreada;
                $idPlanSuscrito = request('id_plan_suscrito', null);

                $diasTrial = ($idPlanSuscrito == 1) ? request('dias_trial', null) : null;
                
                $idTipoPago = request('id_tipo_pago', null);
                $valorSuscripcion = request('valor_suscripcion', null);
                $fechaInicial = request('fecha_inicial', null);
                $fechaFinal = request('fecha_final', null);
                $idEstadoSuscripcion = 13;

                // ===================================================================
                // ===================================================================

                try {
                    // $reqSuscripcionStore = $this->getHttpClient()->post('administracion/suscripcion_store', [
                    $reqSuscripcionStore = $this->clientApi->post($this->baseUri.'administracion/suscripcion_store', [
                        'json' => [
                            'id_empresa_suscrita' => $idEmpresaSuscrita,
                            'id_plan_suscrito' => $idPlanSuscrito,
                            'dias_trial' => $diasTrial,
                            'id_tipo_pago_suscripcion' => $idTipoPago,
                            'valor_suscripcion' => $valorSuscripcion,
                            'fecha_inicial' => $fechaInicial,
                            'fecha_final' => $fechaFinal,
                            'id_estado_suscripcion' => $idEstadoSuscripcion,
                        ]
                    ]);
                    $resSuscripcionStore = json_decode($reqSuscripcionStore->getBody()->getContents());

                    // ===================================================================
                    // ===================================================================

                    if (isset($resSuscripcionStore->success) && $resSuscripcionStore->success) {
                        
                        // Capturamos los datos que retornó la API para usarlos en los correos o en Wompi
                        $empresaData = $resEmpresaStore->empresa;
                        $suscripcionData = $resSuscripcionStore->suscripcion;

                        // ==========================================
                        // CASO 1: ES PLAN DE PRUEBA (id_plan_suscrito == 1)
                        // ==========================================
                        if ($idPlanSuscrito == 1) {
                            
                            try {
                                // Correo al cliente - Plan de prueba
                                Mail::send(
                                    'emails.wompi.pago_aprobado_cliente', // Puede usar una plantilla específica o adaptar esta
                                    ['empresa' => $empresaData, 'suscripcion' => $suscripcionData, 'idTransaccion' => 'TRIAL-15-DIAS'],
                                    function ($m) use ($emailEmpresa, $nombreEmpresa) {
                                        $m->to($emailEmpresa, $nombreEmpresa)
                                        ->subject('¡Bienvenido a la prueba de Storedimo! Tu acceso se está habilitando');
                                    }
                                );

                                // Correo al administrador - Plan de prueba nuevo
                                Mail::send(
                                    'emails.wompi.pago_aprobado_admin',
                                    ['empresa' => $empresaData, 'suscripcion' => $suscripcionData, 'idTransaccion' => 'TRIAL-15-DIAS'],
                                    function ($m) {
                                        $m->to(config('mail.from.address'), 'Administrador Storedimo')
                                        ->cc('softdimo@gmail.com')
                                        ->subject('Nueva suscripción de PRUEBA (Trial) - ' . now()->format('d/m/Y H:i'));
                                    }
                                );
                            } catch (Exception $e) {
                                \Illuminate\Support\Facades\Log::error('Error enviando correos de suscripción trial: ' . $e->getMessage());
                            }

                            // Alerta de éxito local y redirección al resultado o home sin pasar por pasarela
                            alert()->success('¡Registro Exitoso!', 'Su plan de prueba de 15 días ha sido activado correctamente.');
                            
                            // Opción A: Retornar directamente la vista de resultado simulando el éxito
                            return view('wompi.checkout.resultado_pago', [
                                'id_transaccion' => 'TRIAL-15-DIAS',
                                'estado'         => 'APPROVED',
                            ]);
                        }

                        // ==========================================
                        // CASO 2: PLAN PAGO (Requiere pasarela de Wompi)
                        // ==========================================
                        
                        // 1. Calculamos el valor en centavos para Wompi
                        $valorEnCentavos = intval($valorSuscripcion * 100);

                        // 2. Definimos la referencia única uniendo ID y timestamp
                        $referencia = "STOR-" . $suscripcionData->id_suscripcion . "-" . time();
                    
                        // 3. Generamos la firma de integridad leyendo directamente desde el .env
                        $secretoIntegridad = config('services.wompi.integrity_secret');
                        $cadenaFirma = $referencia . $valorEnCentavos . "COP" . $secretoIntegridad;
                        $firmaHash = hash('sha256', $cadenaFirma);

                        \Illuminate\Support\Facades\Log::info('Wompi firma debug', [
                            'referencia'      => $referencia,
                            'valorEnCentavos' => $valorEnCentavos,
                            'tipo_valor'      => gettype($valorEnCentavos),
                            'cadenaFirma'     => $referencia . $valorEnCentavos . "COP" . $secretoIntegridad,
                            'firmaHash'       => $firmaHash,
                        ]);
                    
                        // 4. Retornamos la vista de pago con el Widget de Wompi
                        return view('wompi.checkout.pago_wompi', [
                            'valor' => $valorEnCentavos,
                            'referencia' => $referencia,
                            'firma' => $firmaHash,
                            'email' => $emailEmpresa,
                            'nombre' => $nombreEmpresa,
                            'celular'    => $celularEmpresa,
                            'publicKey' => config('services.wompi.public_key')
                        ]);
                    }

                } catch (Exception $e) {
                    alert()->error('Error', 'Creando la Suscripción, contacte a Soporte.');
                    return back();
                }
            }

        } catch (Exception $e) {
            alert()->error('Error', 'Creando la empresa, contacte a Soporte.');
            return back();
        }
    } // FIN toResponse

    // ===================================================================
    // ===================================================================

    public function consultarEmpresa($nitEmpresa, $nombreEmpresa)
    {
        // $consultarEmpresa = $this->getHttpClient()->post('administracion/consultar_empresa', [
        $consultarEmpresa = $this->clientApi->post($this->baseUri.'administracion/consultar_empresa', [
            'json' => [
                'nit_empresa' => $nitEmpresa,
                'nombre_empresa' => $nombreEmpresa
            ]
        ]);
        return json_decode($consultarEmpresa->getBody()->getContents());
    }
} // FIN Class EmpresaStore
