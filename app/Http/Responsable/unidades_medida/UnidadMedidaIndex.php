<?php

namespace App\Http\Responsable\unidades_medida;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class UnidadMedidaIndex implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'unidad_medida_index', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $unidadesMedida = json_decode($peticion->getBody()->getContents());

            return view('unidades_medida.index', compact('unidadesMedida'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception consultando unidades de medida, contacte a Soporte.');
            return back();
        }
    }
}
