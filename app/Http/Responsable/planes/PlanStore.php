<?php

namespace App\Http\Responsable\planes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PlanStore implements Responsable
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

        $nombrePlan = request('nombre_plan', null);
        $valorMensual = request('valor_mensual', null);
        $valorTrimestral = request('valor_trimestral', null);
        $valorSemestral = request('valor_semestral', null);
        $valorAnual = request('valor_anual', null);
        $descripcionPlan = request('descripcion_plan', null);
        $idEstadoPlan = request('id_estado_plan', null);

        // ========================================================

        try {
            $reqPlanStore = $this->clientApi->post($this->baseUri.'administracion/plan_store', [
                'json' => [
                    'nombre_plan' => $nombrePlan,
                    'valor_mensual' => $valorMensual,
                    'valor_trimestral' => $valorTrimestral,
                    'valor_semestral' => $valorSemestral,
                    'valor_anual' => $valorAnual,
                    'descripcion_plan' => $descripcionPlan,
                    'id_estado_plan' => $idEstadoPlan,
                    'id_audit' => session('id_usuario')
                ]
            ]);
            $resPlanStore = json_decode($reqPlanStore->getBody()->getContents());

            if(isset($resPlanStore->success) && $resPlanStore->success) {
                alert()->success('Proceso Exitoso', 'Plan creado satisfactoriamente');
                return redirect()->to(route('planes.index'));
            }

        } catch (Exception $e) {
            alert()->error('Error', 'Creando el Plan, contacte a Soporte.');
            return back();
        }
    }
} // FIN Class EmpresaStore
