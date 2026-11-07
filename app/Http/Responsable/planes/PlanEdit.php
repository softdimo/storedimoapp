<?php

namespace App\Http\Responsable\planes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PlanEdit implements Responsable
{
    protected $idPlan;

    public function __construct($idPlan)
    {
        $this->idPlan = $idPlan;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        $jwtToken = session('api_jwt_token');

        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            if ($this->planTieneSuscripcionActiva($clientApi, $jwtToken, $this->idPlan)) {
                alert()->error('Error', 'No se puede editar el plan porque tiene una suscripción activa relacionada.');
                return redirect()->to(route('planes.index'));
            }

            $peticion = $clientApi->get('administracion/plan_edit/'. $this->idPlan, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken, // <--- JWT Inyectado
                    'Accept'        => 'application/json',
                ]
            ]);
            $planEdit = json_decode($peticion->getBody()->getContents());

            return view('planes.edit', compact('planEdit'));

        } catch (Exception $e) {
            alert()->error('Editando el Plan, contacte a Soporte.');
            return back();
        }
    }

    private function planTieneSuscripcionActiva($clientApi, $jwtToken, $idPlan)
    {
        try {
            $peticion = $clientApi->get('administracion/plan_tiene_suscripcion_activa/' . $idPlan, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken,
                    'Accept'        => 'application/json',
                ],
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
