<?php

namespace App\Http\Responsable\suscripciones;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class SuscripcionIndex implements Responsable
{
    public $rolId;
    public $usuarioId;

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
            $peticion = $clientApi->get($baseUri . 'administracion/suscripcion_index',[
                'query' => [
                    'id_rol' => $this->rolId,
                    'id_usuario' => $this->usuarioId
                ]
            ]);

            $suscripcionesIndex = json_decode($peticion->getBody()->getContents());

            view()->share('rolId', $this->rolId);
            return view('suscripciones.index', compact('suscripcionesIndex'));
            
        } catch (Exception $e)
        {
            alert()->error('Error', 'Exception Index Suscripciones, contacte a Soporte.');
            return back();
        }
    }
}
