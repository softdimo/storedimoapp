<?php

namespace App\Http\Responsable\existencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class BajaIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'baja_index', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $bajasIndex = json_decode($peticion->getBody()->getContents());

            // Obtener detalles de cada compra
            // foreach ($bajasIndex as $baja) {
            //     $detallePeticion = $clientApi->post($baseUri . 'baja_detalle/' . $baja->id_baja, [
            //         'json' => [
            //             'empresa_actual' => session('empresa_actual.id_empresa')
            //         ]
            //     ]);
            //     $baja->detalles = json_decode($detallePeticion->getBody()->getContents());
            // }

            return view('existencias.bajas_index', compact('bajasIndex'));
            
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Bajas, contacte a Soporte.');
            return back();
        }
    }
}
