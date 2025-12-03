<?php

namespace App\Http\Responsable\suscripciones;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class SuscripcionUpdate implements Responsable
{
    protected $baseUri;
    protected $clientApi;
    protected $idSuscripcion;

    public function __construct($idSuscripcion)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idSuscripcion = $idSuscripcion;
    }

    // ===================================================================

    public function toResponse($request)
    {
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

        // ===================================================================

        // Obtener los datos actuales del producto antes de actualizar
        $peticionSuscripcionEmpresa = $this->clientApi->get($this->baseUri.'administracion/suscripcion_edit/'.$this->idSuscripcion);
        $suscripcionActual = json_decode($peticionSuscripcionEmpresa->getBody()->getContents());

        try {
            $reqSuscripcionEmpresaUpdate = $this->clientApi->put($this->baseUri.'administracion/suscripcion_update/'.$this->idSuscripcion, [
                'json' => [
                    'id_plan_suscrito' => $idPlanSuscrito ?? $suscripcionActual->id_plan_suscrito,
                    'dias_trial' => $diasTrial ?? $suscripcionActual->dias_trial,
                    'id_tipo_pago_suscripcion' => $idTipoPago ?? $suscripcionActual->id_tipo_pago_suscripcion,
                    'valor_suscripcion' => $valorSuscripcion ?? $suscripcionActual->valor_suscripcion,
                    'fecha_inicial' => $fechaInicial ?? $suscripcionActual->fecha_inicial,
                    'fecha_final' => $fechaFinal ?? $suscripcionActual->fecha_final,
                    'id_estado_suscripcion' => $idEstadoSuscripcion ?? $suscripcionActual->id_estado_suscripcion,
                    'fecha_cancelacion' => $fechaCancelacion ?? $suscripcionActual->fecha_cancelacion,
                    'renovacion_automatica' => $renovacionAutomatica ?? $suscripcionActual->renovacion_automatica,
                    'observaciones_suscripcion' => $observacionesSuscripcion ?? $suscripcionActual->observaciones_suscripcion,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resSuscripcionEmpresaUpdate = json_decode($reqSuscripcionEmpresaUpdate->getBody()->getContents());

            if(isset($resSuscripcionEmpresaUpdate->success) && $resSuscripcionEmpresaUpdate->success) {
                alert()->success('Proceso Exitoso', 'Suscripción editada satisfactoriamente');
                return redirect()->to(route('suscripciones.index'));
            }
        } catch (Exception $e) {
            dd($e);
            alert()->error('Error', 'Actualizando la Suscripción, contacte a Soporte.');
            return back();
        }
    }
}
