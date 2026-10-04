<?php

namespace App\Http\Responsable\entradas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class DetalleEntrada implements Responsable
{
    protected $idEntrada;

    public function __construct($idEntrada)
    {
        $this->idEntrada = $idEntrada;
    }
    public function toResponse($request)
    {
        $jwtToken = session('api_jwt_token');

        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'entrada/'. $this->idEntrada, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken, // <--- JWT Inyectado
                    'Accept'        => 'application/json',
                ],
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            $entrada = json_decode($peticion->getBody()->getContents());

            // Obtener detalles de cada compra
            $detallePeticion = $clientApi->post($baseUri . 'detalle_compra/' . $this->idEntrada, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken, // <--- JWT Inyectado
                    'Accept'        => 'application/json',
                ],
                'json' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $entradaDetalles = json_decode($detallePeticion->getBody()->getContents());

            // Recibe el tipo de modal desde la request
            $tipoModal = $request->get('tipo_modal', 'detalle_compra'); // valor por defecto

            return match ($tipoModal) {
                'anular_compra' => view('entradas.modal_anular_entrada', compact('entrada')),
                default  => view('entradas.modal_detalle_entrada', compact('entrada', 'entradaDetalles')),
            };
            
        } catch (Exception $e) {
            alert()->error('Error', 'Consultando la compra, contacte a Soporte.');
            return back();
        }
    }
}
