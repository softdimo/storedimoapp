<?php

namespace App\Http\Responsable\metricas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class MetricaIndex implements Responsable
{
    public function toResponse($request)
    {
        $jwtToken = session('api_jwt_token');

        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            $response = $clientApi->get('administracion/metricas_index', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken, // <--- JWT Inyectado
                    'Accept'        => 'application/json',
                ]
            ]);

            $metricasIndex = json_decode(trim($response->getBody()->getContents())); // Trim para limpiar espacios

            return view('metricas.index', compact('metricasIndex'));
            
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Métricas, contacte a Soporte.');
            return back();
        }
    }
}
