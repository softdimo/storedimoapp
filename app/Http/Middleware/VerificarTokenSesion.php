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
                    $userBd = DB::connection('mysql')
                                ->table('usuarios')
                                ->select('session_token')
                                ->where('id_usuario', $idUsuario)
                                ->first();
                    
                    $tokenReal = $userBd->session_token ?? null;

                    /*
                    |--------------------------------------------------------------------------
                    | OPCIÓN B: CONSULTA VÍA API (COMENTADA PARA COMPARACIÓN)
                    |--------------------------------------------------------------------------
                    | $client = new Client(['base_uri' => env('BASE_URI')]);
                    | $response = $client->get("administracion/usuario_edit/{$idUsuario}", [
                    |     'query' => ['empresa_actual' => Session::get('id_empresa')],
                    |     'timeout' => 3
                    | ]);
                    | $usuarioApi = json_decode($response->getBody()->getContents());
                    | $tokenReal = $usuarioApi->session_token ?? null;
                    */

                    // VALIDACIÓN
                    if (!$tokenReal || $tokenReal !== $tokenEnSesion) {
                        Log::warning("Sesión invalidada por token incorrecto. Usuario: {$idUsuario}");
                        
                        Session::flush();

                        if ($request->ajax()) {
                            return response()->json(['error' => 'Sesión no válida'], 401);
                        }

                        return redirect()->route('login')->with('error_sesion', 'Su sesión ha caducado por seguridad.');
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
