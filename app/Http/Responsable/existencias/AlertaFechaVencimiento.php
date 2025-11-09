<?php

namespace App\Http\Responsable\existencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class AlertaFechaVencimiento implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'alerta_fecha_vencimiento', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);

            $alertaFechaVencimiento = json_decode($peticion->getBody()->getContents(), true);

            // 🔹 Si la petición es AJAX, devolvemos JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($alertaFechaVencimiento);
            }

            return view('layouts.topbar', compact('alertaFechaVencimiento'));
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index stockMinimoIndex, contacte a Soporte.');
            return back();
        }
    }
}
