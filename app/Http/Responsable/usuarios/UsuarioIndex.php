<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class UsuarioIndex implements Responsable
{
    public function toResponse($request)
    {
        $jwtToken = session('api_jwt_token');

        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            // $response = $clientApi->get($baseUri . 'administracion/usuarios_index', [
            $response = $clientApi->get('administracion/usuarios_index', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken, // <--- JWT Inyectado
                    'Accept'        => 'application/json',
                ],
                'query' => [
                    'id_empresa_usuario' => session('empresa_actual.id_empresa')
                ],
                // 'timeout' => 5.0
            ]);
            $usuarioIndex = json_decode($response->getBody()->getContents());
            
            return view('usuarios.index', compact('usuarioIndex'));
            
        } catch (Exception $e) {
            alert()->error('Error cargando los usuarios.');
            return back();
        }
    }
}
