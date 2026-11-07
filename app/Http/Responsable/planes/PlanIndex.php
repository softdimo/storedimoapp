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
            $planesConSuscripcionActiva = $this->obtenerPlanesConSuscripcionActiva($clientApi, $jwtToken);

            return view('planes.index', compact('planesIndex', 'planesConSuscripcionActiva'));
            
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Planes, contacte a Soporte.');
            return back();
        }
    }

    private function obtenerPlanesConSuscripcionActiva($clientApi, $jwtToken)
    {
        try {
            $peticion = $clientApi->get('administracion/planes_con_suscripcion_activa', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken,
                    'Accept'        => 'application/json',
                ],
            ]);

            $respuesta = json_decode($peticion->getBody()->getContents());

            // Acepta arreglo directo o estructura { data: [...] } / { planes: [...] }
            if (is_array($respuesta)) {
                $planes = $respuesta;
            } elseif (isset($respuesta->data) && is_array($respuesta->data)) {
                $planes = $respuesta->data;
            } elseif (isset($respuesta->planes) && is_array($respuesta->planes)) {
                $planes = $respuesta->planes;
            } else {
                $planes = [];
            }

            return array_values(array_unique(array_map('intval', $planes)));
        } catch (Exception $e) {
            return [];
        }
    }
}
