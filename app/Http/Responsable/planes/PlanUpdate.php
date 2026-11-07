<?php

namespace App\Http\Responsable\planes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PlanUpdate implements Responsable
{
    protected $baseUri;
    protected $clientApi;
    protected $idPlan;

    public function __construct($idPlan)
    {
        $this->baseUri = env('BASE_URI');
        $this->clientApi = new Client(['base_uri' => $this->baseUri]);
        $this->idPlan = $idPlan;
    }

    /* Helper privado para obtener las cabeceras estándar con JWT */
    private function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . session('api_jwt_token'),
            'Accept'        => 'application/json',
        ];
    }

    // ===================================================================

    public function toResponse($request)
    {
        if ($this->planTieneSuscripcionActiva($this->idPlan)) {
            alert()->error('Error', 'No se puede editar el plan porque tiene una suscripción activa relacionada.');
            return redirect()->to(route('planes.index'));
        }

        $nombrePlan = request('nombre_plan', null);
        $valorMensual = request('valor_mensual', null);
        $valorTrimestral = request('valor_trimestral', null);
        $valorSemestral = request('valor_semestral', null);
        $valorAnual = request('valor_anual', null);
        $descripcionPlan = request('descripcion_plan', null);
        $idEstadoPlan = request('id_estado_plan', null);

        // ===================================================================

        // Obtener los datos actuales del producto antes de actualizar
        $planActualConsulta = $this->clientApi->get('administracion/plan_edit/'.$this->idPlan, [
            'headers' => $this->getHeaders(),
        ]);
        $planActual = json_decode($planActualConsulta->getBody()->getContents());

        try {
            $reqPlanUpdate = $this->clientApi->put('administracion/plan_update/'.$this->idPlan, [
                'headers' => $this->getHeaders(),
                'json' => [
                    'nombre_plan' =>  $nombrePlan ?? $planActual->nombre_plan,
                    'valor_mensual' => doubleval(str_replace(".", "", $valorMensual)) ?? $planActual->valor_mensual,
                    'valor_trimestral' => doubleval(str_replace(".", "", $valorTrimestral)) ?? $planActual->valor_trimestral,
                    'valor_semestral' => doubleval(str_replace(".", "", $valorSemestral)) ?? $planActual->valor_semestral,
                    'valor_anual' => doubleval(str_replace(".", "", $valorAnual)) ?? $planActual->valor_anual,
                    'descripcion_plan' => $descripcionPlan ?? $planActual->descripcion_plan,
                    'id_estado_plan' => $idEstadoPlan ?? $planActual->id_estado_plan,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resPlanUpdate = json_decode($reqPlanUpdate->getBody()->getContents());

            if(isset($resPlanUpdate->success) && $resPlanUpdate->success) {
                alert()->success('Proceso Exitoso', 'Plan editado satisfactoriamente');
                return redirect()->to(route('planes.index'));
            }
        } catch (Exception $e) {
            alert()->error('Error', 'Actualizando el Plan, contacte a Soporte.');
            return back();
        }
    }

    private function planTieneSuscripcionActiva($idPlan)
    {
        try {
            $peticion = $this->clientApi->get('administracion/plan_tiene_suscripcion_activa/' . $idPlan, [
                'headers' => $this->getHeaders(),
            ]);

            $respuesta = json_decode($peticion->getBody()->getContents());

            if (isset($respuesta->tiene_suscripcion_activa)) {
                return (bool) $respuesta->tiene_suscripcion_activa;
            }

            if (isset($respuesta->data->tiene_suscripcion_activa)) {
                return (bool) $respuesta->data->tiene_suscripcion_activa;
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
