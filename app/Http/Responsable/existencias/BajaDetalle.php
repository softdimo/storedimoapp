<?php

namespace App\Http\Responsable\existencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class BajaDetalle implements Responsable
{
    protected $idBaja;

    public function __construct($idBaja)
    {
        $this->idBaja = $idBaja;
    }

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'baja/'. $this->idBaja, [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $baja = json_decode($peticion->getBody()->getContents());

            // Obtener detalles de cada baja
            $detallePeticion = $clientApi->post($baseUri . 'baja_detalle/'. $this->idBaja, [
                'json' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $bajaDetalles = json_decode($detallePeticion->getBody()->getContents());

            

            return view('existencias.modal_detalle_baja', compact('baja', 'bajaDetalles'));
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Bajas, contacte a Soporte.');
            return back();
        }
    }
}
