<?php

namespace App\Http\Responsable\empresas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class EmpresaIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'administracion/empresa_index');
            $empresas = json_decode($peticion->getBody()->getContents());

            return view('empresas.index', compact('empresas'));
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Empresas, contacte a Soporte.');
            return back();
        }
    }
}
