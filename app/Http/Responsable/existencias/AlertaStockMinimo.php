<?php

namespace App\Http\Responsable\existencias;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use GuzzleHttp\Client;

class AlertaStockMinimo implements Responsable
{
    public function toResponse($request)
    {
        $jwtToken = session('api_jwt_token');

        try {
            $baseUri = env('BASE_URI');
            $clientApi = new Client(['base_uri' => $baseUri]);
            
            // Realiza la solicitud a la API
            $peticion = $clientApi->get($baseUri . 'alerta_stock_minimo', [
            // $peticion = $clientApi->get('alerta_stock_minimo', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken, // <--- Header JWT Inyectado
                    'Accept'        => 'application/json',
                ],
                'query' => [
                    'empresa_actual' => session('empresa_actual.id_empresa')
                ],
                'timeout' => 4.0
            ]);
            $alertaStockMinimo = json_decode($peticion->getBody()->getContents(), true);

            // 🔹 Si la petición es AJAX, devolvemos JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($alertaStockMinimo);
            }

            return view('layouts.topbar', compact('alertaStockMinimo'));

        } catch (Exception $e) {
            logger()->error("Error en AlertaStockMinimo Responsable: " . $e->getMessage());

            // Si falla una petición AJAX, respondemos un JSON controlado
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => 'Error al consultar las alertas de stock mínimo.'
                ], 500);
            }

            alert()->error('Error', 'Exception Index stockMinimoIndex, contacte a Soporte.');
            return back();
        }
    }
}
