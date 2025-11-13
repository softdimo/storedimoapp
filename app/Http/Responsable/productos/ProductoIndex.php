<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ProductoIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'producto_index', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            $productos = json_decode($response->getBody()->getContents());

            return view('productos.index', compact('productos'));
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Cargando Productos, contacte a Soporte.');
            return back();
        }
    }
}
