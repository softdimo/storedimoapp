<?php

namespace App\Http\Responsable\productos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class ProductoDestroy implements Responsable
{
    public function toResponse($request)
    {
        $idProducto = request('id_producto', null);

        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // Realiza la solicitud a la API
            $response = $clientApi->post($baseUri . 'cambiar_estado_producto/'.$idProducto, [
                'json' => [
                    'id_audit' => session('id_usuario'),
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $respuesta = json_decode($response->getBody()->getContents());

            if(isset($respuesta->success) && $respuesta->success === true) {

                alert()->success('Proceso Exitoso', 'Estado cambiado satisfactoriamente');
                return redirect()->to(route('productos.index'));
            }
        } catch (Exception $e)
        {
            alert()->error('Error', 'Cambiando el estado del producto, contacte a Soporte.');
            return back();
        }
    }
}
