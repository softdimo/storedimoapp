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
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $peticion = $clientApi->get($baseUri . 'administracion/plan_edit/'. $this->idPlan);
            $planEdit = json_decode($peticion->getBody()->getContents());

            return view('planes.edit', compact('planEdit'));

        } catch (Exception $e) {
            alert()->error('Editando el Plan, contacte a Soporte.');
            return back();
        }
    }
}
