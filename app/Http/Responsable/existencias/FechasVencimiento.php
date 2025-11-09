<?php

namespace App\Http\Responsable\existencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class FechasVencimiento implements Responsable
{
    public function toResponse($request)
    {
        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'fechas_vencimiento_index', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            $fechasVencimientoIndex = json_decode($peticion->getBody()->getContents());
            return view('existencias.fechas_vencimiento', compact('fechasVencimientoIndex'));

        } catch (Exception $e)
        {
            alert()->error('Error', 'Exception en fechasVencimientoIndex, contacte a Soporte.');
            return back();
        }
    }
}
