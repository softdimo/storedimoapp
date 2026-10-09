<?php

namespace App\Http\Responsable\personas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PersonaIndex implements Responsable
{
    public function toResponse($request)
    {
        try
        {
            $jwtToken = session('api_jwt_token');

            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $response = $clientApi->get('personas_index', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken,
                    'Accept'        => 'application/json',
                ],
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            return json_decode($response->getBody()->getContents());
            
        } catch (Exception $e)
        {
            return null;
        }
    }
}
