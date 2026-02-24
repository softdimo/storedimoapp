<?php

namespace App\Http\Responsable\metricas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class MetricaIndex implements Responsable
{
    public function toResponse($request)
    {
        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $response = $clientApi->get($baseUri . 'administracion/metricas_index', []);
            // 1. Obtenemos el cuerpo de la respuesta
            // $contents = $response->getBody()->getContents();
            $contents = trim($response->getBody()->getContents()); // Trim para limpiar espacios

            // 2. Decodificamos forzando a ARRAY (usando el segundo parámetro true)
            // Esto evita problemas de tipos con stdClass en algunos foreach
            $metricasIndex = json_decode($contents);

            // 3. Validación de seguridad: Si no es un array, enviamos uno vacío, SI FALLA LA DECODIFICACIÓN O NO ES ARRAY/OBJETO
            if (json_last_error() !== JSON_ERROR_NONE || (!is_array($metricasIndex) && !is_object($metricasIndex))) {
                $metricasIndex = [];
            }

            return view('metricas.index', compact('metricasIndex'));
            
        } catch (Exception $e)
        {
            alert()->error('Error', 'Exception Index Métricas, contacte a Soporte.');
            return back();
        }
    }
}
