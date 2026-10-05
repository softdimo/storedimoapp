<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Exception;

class VerificarTokenSesion
{
    public function handle($request, Closure $next)
    {
        if (Session::has('id_usuario')) {
            
            $ahora = now();
            $ultimaValidacion = Session::get('ultima_validacion_token');
            // Evita consultar la API en cada request (reduce carreras y falsos deslogueos)
            $intervaloSegundos = 60; // 1 minuto

            // Solo consultamos si es la primera vez o si ya pasó el intervalo
            if (!$ultimaValidacion || $ahora->diffInSeconds($ultimaValidacion) > $intervaloSegundos) {
                
                $idUsuario = Session::get('id_usuario');
                $tokenEnSesion = Session::get('session_token');
                $jwtToken = Session::get('api_jwt_token');

                // Sin JWT o sin token local, no invalidamos (evita bucles/falsos positivos)
                if (!$jwtToken || !$tokenEnSesion) {
                    return $next($request);
                }

                try {
                    $client = new Client(['base_uri' => env('BASE_URI')]);
                    
                    $response = $client->get("administracion/consultar_session_token/{$idUsuario}?t=" . time(), [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $jwtToken,
                            'Accept'        => 'application/json',
                        ],
                        // 'timeout' => 3
                    ]);
                    $datosApi = json_decode($response->getBody()->getContents());

                    $tokenReal = isset($datosApi->session_token) ? $datosApi->session_token : null;

                    // Si la API no devolvió token, NO cerramos sesión (puede ser falla temporal)
                    if (!$tokenReal) {
                        Log::warning("VerificarTokenSesion: token remoto vacío/nulo. Usuario: {$idUsuario}. Se mantiene la sesión.");
                        return $next($request);
                    }

                    // Solo invalidar cuando hay evidencia clara de mismatch
                    if ($tokenReal !== $tokenEnSesion) {
                        Log::warning("Sesión invalidada por token incorrecto. Usuario: {$idUsuario}");
                        
                        Session::flush();

                        if ($request->ajax()) {
                            return response()->json(['error' => 'Sesión no válida'], 401);
                        }

                        return redirect()->route('login')->with('error_sesion', 'Por seguridad, su sesión ha caducado.');
                    }

                    Session::put('ultima_validacion_token', $ahora);

                } catch (Exception $e) {
                    // Error de red/API: no cerrar sesión
                    Log::error("Error en Middleware VerificarTokenSesion: " . $e->getMessage());
                }
            }
        }

        return $next($request);
    }
}
