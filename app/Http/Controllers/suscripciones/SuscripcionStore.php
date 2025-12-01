<?php

namespace App\Http\Responsable\suscripciones;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class SuscripcionStore implements Responsable
{
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

        // dd(request()->all());

        $idEmpresaSuscrita = request('id_empresa_suscrita', null);
        $idPlanSuscrito = request('id_plan_suscrito', null);
        $diasTrial = request('dias_trial', null);
        $idTipoPago = request('id_tipo_pago', null);
        $valorSuscripcion = request('valor_suscripcion', null);
        $fechaInicial = request('fecha_inicial', null);
        $fechaFinal = request('fecha_final', null);
        $idEstadoSuscripcion = request('id_estado_suscripcion', null);
        $fechaCancelacion = request('fecha_cancelacion', null);
        $renovacionAutomatica = request('renovacion_automatica', null);
        $observacionesSuscripcion = request('observaciones_suscripcion', null);

        // ========================================================

        // $consultarSuscripcionEmpresa = $this->consultarSuscripcionEmpresa($idEmpresaSuscrita);

        // if (isset($consultarSuscripcionEmpresa) && !is_null($consultarSuscripcionEmpresa) && !empty($consultarSuscripcionEmpresa)) {
        //     alert()->warning('Cuidado', 'Empresa existente');
        //     return redirect()->route('empresas.create')->withInput();
        // }
        
        try {
            $reqSuscripcionStore = $this->clientApi->post($this->baseUri.'administracion/suscripcion_store', [
                'json' => [
                    'id_empresa_suscrita' => $idEmpresaSuscrita,
                    'id_plan_suscrito' => $idPlanSuscrito,
                    'dias_trial' => $diasTrial,
                    'id_tipo_pago' => $idTipoPago,
                    'valor_suscripcion' => $valorSuscripcion,
                    'fecha_inicial' => $fechaInicial,
                    'fecha_final' => $fechaFinal,
                    'id_estado_suscripcion' => $idEstadoSuscripcion,
                    'fecha_cancelacion' => $fechaCancelacion,
                    'renovacion_automatica' => $renovacionAutomatica,
                    'observaciones_suscripcion' => $observacionesSuscripcion,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resSuscripcionStore = json_decode($reqSuscripcionStore->getBody()->getContents());

            if(isset($resSuscripcionStore->success) && $resSuscripcionStore->success) {
                alert()->success('Proceso Exitoso', 'Suscripción creada satisfactoriamente');
                return redirect()->to(route('suscripciones.index'));
            }

        } catch (Exception $e) {
            alert()->error('Error', 'Creando la Suscripción, contacte a Soporte.');
            return back();
        }
    }

    // ===================================================================
    // ===================================================================

    // public function consultarSuscripcionEmpresa($idEmpresaSuscrita)
    // {
    //     $consultarSuscripcionEmpresa = $this->clientApi->post($this->baseUri.'administracion/consultar_suscripcion_empresa', [
    //         'json' => [
    //             'id_empresa_suscrita' => $idEmpresaSuscrita
    //         ]
    //     ]);
    //     return json_decode($consultarSuscripcionEmpresa->getBody()->getContents());
    // }
} // FIN Class EmpresaStore
