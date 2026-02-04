<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
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
            // 600 segundos = 10 minutos de "paz" para el servidor
            $intervaloSegundos = 0;
            // $intervaloSegundos = 600; // 10 minutos
            // $intervaloSegundos = 1200; // 20 minutos
            // $intervaloSegundos = 1800; // 30 minutos
            // $intervaloSegundos = 2400; // 40 minutos
            // $intervaloSegundos = 3000; // 50 minutos
            // $intervaloSegundos = 3600; // 60 minutos
            // $intervaloSegundos = 4200; // 70 minutos
            // $intervaloSegundos = 4800; // 80 minutos
            // $intervaloSegundos = 5400; // 90 minutos
            // $intervaloSegundos = 6000; // 100 minutos
            // $intervaloSegundos = 36000; // 10 horas
            // $intervaloSegundos = 43200; // 12 horas
            // $intervaloSegundos = 86400; // 24 horas
            // $intervaloSegundos = 172800; // 48 horas
            // $intervaloSegundos = 259200; // 72 horas
            // $intervaloSegundos = 345600; // 96 horas
            // $intervaloSegundos = 432000; // 120 horas
            // $intervaloSegundos = 518400; // 144 horas

            // Solo entramos a consultar si es la primera vez o si ya pasaron 10 minutos
            if (!$ultimaValidacion || $ahora->diffInSeconds($ultimaValidacion) > $intervaloSegundos) {
                
                $idUsuario = Session::get('id_usuario');
                $tokenEnSesion = Session::get('session_token');

                try {
                    /*
                    |--------------------------------------------------------------------------
                    | OPCIÓN A: CONSULTA DIRECTA (ACTIVA)
                    |--------------------------------------------------------------------------
                    */
                    // $userBd = DB::connection('mysql')
                    //             ->table('usuarios')
                    //             ->select('session_token')
                    //             ->where('id_usuario', $idUsuario)
                    //             ->first();
                    
                    // $tokenReal = $userBd->session_token ?? null;

                    
                    // |--------------------------------------------------------------------------
                    // | OPCIÓN B: CONSULTA VÍA API (COMENTADA PARA COMPARACIÓN)
                    // |--------------------------------------------------------------------------
                    $client = new Client(['base_uri' => env('BASE_URI')]);
                    
                    // Añadimos ?t=timestamp para forzar a la API a darnos el dato fresco de la BD
                    $response = $client->get("administracion/consultar_session_token/{$idUsuario}?t=" . time(), [
                        'timeout' => 3
                    ]);
                    $datosApi = json_decode($response->getBody()->getContents());

                    // Extraemos el token del objeto JSON correctamente
                    $tokenReal = isset($datosApi->session_token) ? $datosApi->session_token : null;
                    
                    // VALIDACIÓN
                    if (!$tokenReal || $tokenReal !== $tokenEnSesion) {
                        Log::warning("Sesión invalidada por token incorrecto. Usuario: {$idUsuario}");
                        
                        Session::flush();

                        if ($request->ajax()) {
                            return response()->json(['error' => 'Sesión no válida'], 401);
                        }

                        return redirect()->route('login')->with('error_sesion', 'Por seguridad, su sesión ha caducado debido al cambio de clave.');
                    }

                    // Si todo está bien, renovamos el sello de tiempo para no volver a consultar en 10 min
                    Session::put('ultima_validacion_token', $ahora);

                } catch (Exception $e) {
                    Log::error("Error en Middleware VerificarTokenSesion: " . $e->getMessage());
                }
            }
        }

        return $next($request);
    }
}
