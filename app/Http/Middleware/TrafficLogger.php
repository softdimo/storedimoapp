<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;

class TrafficLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Ejecutamos la petición primero
        $response = $next($request);

        try {
            /**
             * 2. Obtener el nombre de la base de datos actual.
             * Como tu Helper hace Config::set('database.connections.tenant.database', ...),
             * el valor que obtenemos aquí ya es el valor que el Helper desencriptó
             * y puso en la configuración en tiempo de ejecución.
             */
            // $currentDb = Config::get('database.connections.tenant.database');

            // Si por alguna razón no hay conexión tenant activa, usamos la principal por defecto
            // $tenantName = $currentDb ?: env('DB_DATABASE', 'Storedimo_Principal');

            // 3. Insertar en la tabla de logs de la BD principal
            // DB::connection('mysql')->table('traffic_logs')->insert([
            //     'tenant_db'   => $tenantName,
            //     'source'      => 'WEB_APP',
            //     'method'      => $request->method(),
            //     'path'        => $request->path(),
            //     'ip'          => $request->ip(),
            //     'status_code' => $response->getStatusCode(),
            //     'user_agent'  => $request->userAgent(),
            //     'created_at'  => now(),
            //     'updated_at'  => now(),
            // ]);

            // 2. Configuramos el cliente de Guzzle igual que en tu controlador
            $baseUri = env('BASE_URI');
            $client = new Client(['base_uri' => $baseUri]);

            // 3. Preparamos los datos
            $datosParaLog = [
                'tenant_db'   => Config::get('database.connections.tenant.database') ?? env('DB_DATABASE', 'u524250720_storedimo'),
                'source'      => 'WEB_APP',
                'method'      => $request->method(),
                'path'        => $request->path(),
                'ip'          => $request->ip(),
                'status_code' => $response->getStatusCode(),
                'user_agent'  => $request->userAgent(),
            ];

            // 4. Llamamos a la API
            // Usamos la ruta completa o relativa a baseUri
            $client->post('administracion/metricas_store', [
                'json' => $datosParaLog,
                'timeout' => 2 // Muy importante: si la API no responde en 2s, sigue adelante
            ]);

        } catch (\Exception $e) {
            // Silenciamos errores para no bloquear la experiencia del usuario
        }

        return $response;
    }
}
