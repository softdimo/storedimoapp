<?php

namespace App\Http\Responsable\proveedores;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ProveedorIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $jwtToken = session('api_jwt_token');

            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $peticion = $clientApi->get('proveedores_index', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken,
                    'Accept'        => 'application/json',
                ],
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $resProveedoresIndex = json_decode($peticion->getBody()->getContents());

            return view('proveedores.index', compact('resProveedoresIndex'));
        } catch (Exception $e)
        {
            alert()->error('Error', 'Exception resProveedoresIndex, contacte a Soporte.');
            return back();
        }
    }
}
