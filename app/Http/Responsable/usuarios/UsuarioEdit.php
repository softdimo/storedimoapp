<?php

namespace App\Http\Responsable\usuarios;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class UsuarioEdit implements Responsable
{
    protected $idUsuario;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $peticion = $clientApi->get($baseUri . 'administracion/usuario_edit/'. $this->idUsuario, [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $usuario = json_decode($peticion->getBody()->getContents());

             // Recibe el tipo de modal desde la request
             $tipoModal = $request->get('tipo_modal', 'editar_usuario'); // valor por defecto

             return match ($tipoModal)
             {
                 'cambiar_clave' => view('usuarios.modal_cambiar_clave', compact('usuario')),
                 default  => view('usuarios.modal_editar_usuario', compact('usuario')),
             };

        } catch (Exception $e) {
            alert()->error('Error consultando el usuario para editar, contacte a Soporte.');
            return back();
        }
    }
}
