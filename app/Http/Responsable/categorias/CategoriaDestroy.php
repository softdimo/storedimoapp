<?php

namespace App\Http\Responsable\categorias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class CategoriaDestroy implements Responsable
{
    public function toResponse($request)
    {
        $idCategoria = request('id_categoria', null);

        try
        {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // Realiza la solicitud a la API
            $response = $clientApi->post(
                $baseUri . 'cambiar_estado_categoria/' . $idCategoria,
                [
                    'json' => [
                        'id_audit' => session('id_usuario'),
                        'empresa_actual' => session('empresa_actual.id_empresa')
                    ]
                ]
            );

            $respuesta = json_decode($response->getBody()->getContents());

            if (isset($respuesta->success) && $respuesta->success === true)
            {

                alert()->success('Proceso Exitoso', 'Estado cambiado satisfactoriamente');
                return redirect()->to(route('categorias.index'));
            }
        } catch (Exception $e)
        {
            alert()->error('Error', 'Cambiando el estado de la categoría, contacte a Soporte.');
            return back();
        }
    }
}
