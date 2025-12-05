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

    // ===================================================================

    public function toResponse($request)
    {
        $nombrePlan = request('nombre_plan', null);
        $valorMensual = request('valor_mensual', null);
        $valorTrimestral = request('valor_trimestral', null);
        $valorSemestral = request('valor_semestral', null);
        $valorAnual = request('valor_anual', null);
        $descripcionPlan = request('descripcion_plan', null);
        $idEstadoPlan = request('id_estado_plan', null);

        // ===================================================================

        // Obtener los datos actuales del producto antes de actualizar
        $planActualConsulta = $this->clientApi->get($this->baseUri.'administracion/plan_edit/'.$this->idPlan);
        $planActual = json_decode($planActualConsulta->getBody()->getContents());

        try {
            $reqPlanUpdate = $this->clientApi->put($this->baseUri.'administracion/plan_update/'.$this->idPlan, [
                'json' => [
                    'nombre_plan' =>  $nombrePlan ?? $planActual->nombre_plan,
                    'valor_mensual' => $valorMensual ?? $planActual->valor_mensual,
                    'valor_trimestral' => $valorTrimestral ?? $planActual->valor_trimestral,
                    'valor_semestral' => $valorSemestral ?? $planActual->valor_semestral,
                    'valor_anual' => $valorAnual ?? $planActual->valor_anual,
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
            dd($e);
            alert()->error('Error', 'Actualizando el Plan, contacte a Soporte.');
            return back();
        }
    }
}
