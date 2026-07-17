<?php

namespace App\Http\Responsable\empresas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class EmpresaIndex implements Responsable
{
    public $rolId;

     public function __construct($rolId, $usuarioId)
    {
        $this->rolId = $rolId;
        $this->usuarioId = $usuarioId;
    }

    public function toResponse($request)
    {
        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'administracion/empresa_index', [
                'query' => [
                    'id_rol' => $this->rolId,
                    'id_usuario' => $this->usuarioId
                ]
            ]);

            $empresas = json_decode($peticion->getBody()->getContents());

            view()->share('rolId', $this->rolId);
            return view('empresas.index', compact('empresas'));
        } catch (Exception $e)
        {
            alert()->error('Error', 'Exception Index Empresas, contacte a Soporte.');
            return back();
        }
    }
}
