<?php

namespace App\Http\Responsable\prestamos;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class PrestamoVencer implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);

            // ==============================================================
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'prestamo_vencer', [
                'json' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $prestamosVencer = json_decode($peticion->getBody()->getContents());

            return view('prestamos.prestamos_vencer', compact('prestamosVencer'));

        } catch (Exception $e) {
            alert()->error('Error', 'Exception, contacte a Soporte.');
            return back();
        }
    }
}
