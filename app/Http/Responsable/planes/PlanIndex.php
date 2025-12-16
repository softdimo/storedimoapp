<?php

namespace App\Http\Responsable\planes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PlanIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'administracion/plan_index');
            $planesIndex = json_decode($peticion->getBody()->getContents());

            return view('planes.index', compact('planesIndex'));
            
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Planes, contacte a Soporte.');
            return back();
        }
    }
}
