<?php

namespace App\Http\Responsable\suscripciones;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class SuscripcionIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'administracion/suscripcion_index');
            $suscripcionesIndex = json_decode($peticion->getBody()->getContents());
            // dd($suscripcionesIndex);

            return view('suscripciones.index', compact('suscripcionesIndex'));
            
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Suscripciones, contacte a Soporte.');
            return back();
        }
    }
}
