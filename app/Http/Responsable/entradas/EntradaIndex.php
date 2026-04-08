<?php

namespace App\Http\Responsable\entradas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;

class EntradaIndex implements Responsable
{
    use MetodosTrait;

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'entrada_index', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $entradas = json_decode($peticion->getBody()->getContents());
            view()->share('entradas', $entradas);

            $sesion = $this->validarVariablesSesion();
            $permisos = $this->permisosPorUsuario($sesion[0]);
            view()->share('permisos', $permisos);

            return view('entradas.index');
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Entradas, contacte a Soporte.');
            return back();
        }
    }
}
