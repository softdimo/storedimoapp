<?php

namespace App\Http\Responsable\categorias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class CategoriaIndex implements Responsable
{
    public function toResponse($request)
    {
        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'categoria_index', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $categorias = json_decode($response->getBody()->getContents());

            return view('categorias.index', compact('categorias'));
        } catch (Exception $e)
        {
            alert()->error('Error', 'Exception Index Categorias, contacte a Soporte.');
            return back();
        }
    }
}
