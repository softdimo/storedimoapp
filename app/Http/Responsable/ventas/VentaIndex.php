<?php

namespace App\Http\Responsable\ventas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class VentaIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'venta_index', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $ventas = json_decode($peticion->getBody()->getContents());

            // Obtener detalles de cada compra
            // foreach ($ventas as $venta) {
            //     $detallePeticion = $clientApi->post($baseUri . 'detalle_venta/' . $venta->id_venta, [
            //         'json' => [
            //             'empresa_actual' => session('empresa_actual.id_empresa')
            //         ]
            //     ]);
            //     $venta->detalles = json_decode($detallePeticion->getBody()->getContents());
            // }

            return view('ventas.index', compact('ventas'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Ventas, contacte a Soporte.');
            return back();
        }
    }
}
