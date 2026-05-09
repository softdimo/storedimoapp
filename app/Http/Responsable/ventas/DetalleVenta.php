<?php

namespace App\Http\Responsable\ventas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class DetalleVenta implements Responsable
{
    protected $idVenta;

    public function __construct($idVenta)
    {
        $this->idVenta = $idVenta;
    }

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'venta/'. $this->idVenta, [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            $venta = json_decode($peticion->getBody()->getContents());

            // Obtener detalles de cada compra
            $detallePeticion = $clientApi->post($baseUri . 'detalle_venta/' . $venta->id_venta, [
                'json' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $ventaDetalles = json_decode($detallePeticion->getBody()->getContents());

             // Recibe el tipo de modal desde la request
            $tipoModal = $request->get('tipo_modal', 'detalle_venta'); // valor por defecto

            return match ($tipoModal) {
                'anular_venta' => view('ventas.modal_anular_venta', compact('venta')),
                default  => view('ventas.modal_detalle_venta', compact('venta', 'ventaDetalles')),
            };

        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Ventas, contacte a Soporte.');
            return back();
        }
    }
}
