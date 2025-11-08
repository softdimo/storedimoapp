<?php

namespace App\Http\Responsable\personas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PersonaEdit implements Responsable
{
    protected $idCliente;

    public function __construct($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    // =============================================================
    // =============================================================

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            $peticion = $clientApi->get($baseUri . 'persona_edit/'. $this->idCliente, [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $persona = json_decode($peticion->getBody()->getContents());

            return view('personas.modal_editar_cliente', compact('persona'));

        } catch (Exception $e) {
            alert()->error('Error Editando el Cliente, contacte a Soporte.');
            return back();
        }
    }
}
