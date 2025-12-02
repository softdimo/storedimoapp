<?php

namespace App\Http\Responsable\suscripciones;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class SuscripcionEdit implements Responsable
{
    protected $idSuscripcion;

    public function __construct($idSuscripcion)
    {
        $this->idSuscripcion = $idSuscripcion;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $peticion = $clientApi->get($baseUri . 'administracion/suscripcion_edit/'. $this->idSuscripcion);
            $suscripcionEdit = json_decode($peticion->getBody()->getContents());

            return view('suscripciones.edit', compact('suscripcionEdit'));

        } catch (Exception $e) {
            alert()->error('Editando la Suscripción, contacte a Soporte.');
            return back();
        }
    }
}
