<?php

namespace App\Http\Responsable\existencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class AlertaStockMinimo implements Responsable
{
    public function toResponse($request)
    {
        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'alerta_stock_minimo', [
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ]
            ]);
            $alertaStockMinimo = json_decode($peticion->getBody()->getContents(), true);

            // 🔹 Si la petición es AJAX, devolvemos JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($alertaStockMinimo);
            }

            return view('layouts.topbar', compact('alertaStockMinimo'));
        } catch (Exception $e) {
            alert()->error('Error', 'Exception Index stockMinimoIndex, contacte a Soporte.');
            return back();
        }
    }
}
