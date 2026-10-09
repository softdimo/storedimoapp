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

            $response = $clientApi->get('administracion/usuarios_index', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken,
                    'Accept'        => 'application/json',
                ],
                'query' => [
                    'id_empresa_usuario' => session('empresa_actual.id_empresa') ?? session('id_empresa')
                ],
            ]);

            $usuarioIndex = json_decode($response->getBody()->getContents());

            // Evita que la vista rompa con foreach(null) y termine en redirect raro
            if (!is_array($usuarioIndex) && !is_object($usuarioIndex)) {
                $usuarioIndex = [];
            }

            return view('usuarios.index', compact('usuarioIndex'));

        } catch (Exception $e) {
            logger()->error('Error UsuarioIndex: ' . $e->getMessage());
            alert()->error('Error cargando los usuarios.');
            return redirect()->route('home.index');
        }
    }
}

