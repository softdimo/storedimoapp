<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class UsuarioIndex implements Responsable
{
    public function toResponse($request)
    {
        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $response = $clientApi->get($baseUri . 'administracion/usuarios_index', [
                'query' => [
                    'id_empresa_usuario' => session('empresa_actual.id_empresa')
                ]
            ]);
            $usuarioIndex = json_decode($response->getBody()->getContents());
            
            return view('usuarios.index', compact('usuarioIndex'));
            
        } catch (Exception $e) {
            alert()->error('Error cargando los usuarios.');
            return back();
        }
    }
}
