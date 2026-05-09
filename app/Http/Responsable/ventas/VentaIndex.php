<?php

namespace App\Http\Responsable\ventas;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;
use App\Traits\MetodosTrait;
class VentaIndex implements Responsable
{
    use MetodosTrait;

    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'venta_index', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            $ventas = json_decode($peticion->getBody()->getContents());
            view()->share('ventas', $ventas);

            $sesion = $this->validarVariablesSesion();
            $permisos = $this->permisosPorUsuario($sesion[0]);

            view()->share('permisos', $permisos);

            return view('ventas.index');

        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index Ventas, contacte a Soporte.');
            return back();
        }
    }
}
