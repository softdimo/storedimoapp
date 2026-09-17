<?php

namespace App\Http\Responsable\planes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PlanIndex implements Responsable
{
    public function toResponse($request)
    {
        $jwtToken = session('api_jwt_token');

        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get('administracion/plan_index', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken, // <--- JWT Inyectado
                    'Accept'        => 'application/json',
                ],
            ]);

            $planesIndex = json_decode($peticion->getBody()->getContents());
            return view('planes.index', compact('planesIndex'));
            
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Planes, contacte a Soporte.');
            return back();
        }
    }
}
