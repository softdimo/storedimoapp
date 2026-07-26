<?php

namespace App\Http\Responsable\suscripciones;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;
use App\Traits\MetodosTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RenovarSuscripcion implements Responsable
{
    public function toResponse($request)
    {
        try
        {
            return view('suscripciones.renovar');

        } catch (Exception $e)
        {
            alert()->error('Error cargando formulario de renovación, contácte a soporte');
            return back();
        }
    }

    public function guardarRenovacionSuscripcion($parametros)
    {
        if (isset($parametros['id_empresa']) && isset($parametros['id_plan_suscrito']))
        {
            $idEmpresaSuscrita = $parametros['id_empresa'];
            $idPlanSuscrito = $parametros['id_plan_suscrito'];
            $diasTrial = $parametros['dias_trial'];
            $idTipoPago = $parametros['id_tipo_pago'];
            $valorSuscripcion = $parametros['valor_suscripcion'];
            $fechaInicial = $parametros['fecha_inicial'];
            $fechaFinal = $parametros['fecha_final'];
            $idEstadoSuscripcion = 13;

            try
            {
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

                if (isset($resSuscripcionStore->success) && $resSuscripcionStore->success)
                {
                    // Capturamos los datos que retornó la API para usarlos en los correos o en Wompi
                    $empresaData = $parametros['empresa_actual'];
                    $suscripcionData = $resSuscripcionStore->suscripcion;

                    if ($idPlanSuscrito == 1)
                    {    
                        try
                        {
                            // Correo al cliente - Plan de prueba
                            Mail::send(
                                'emails.wompi.pago_aprobado_cliente', // Puede usar una plantilla específica o adaptar esta
                                ['empresa' => $empresaData, 'suscripcion' => $suscripcionData, 'idTransaccion' => 'TRIAL-15-DIAS'],
                                function ($m) use ($emailEmpresa, $nombreEmpresa)
                                {
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
                        } catch (Exception $e)
                        {
                            \Illuminate\Support\Facades\Log::error('Error enviando correos de suscripción trial: ' . $e->getMessage());
                        }

                        // Alerta de éxito local y redirección al resultado o home sin pasar por pasarela
                        alert()->success('Renovación Exitosa!', 'Su plan ha sido renovado exitosamente.');
                        
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

            } catch (Exception $e)
            {
                dd($e);
                alert()->error('Error', 'Renovando la Suscripción, contácte a Soporte.');
                return back();
            }
        }
    }
}
