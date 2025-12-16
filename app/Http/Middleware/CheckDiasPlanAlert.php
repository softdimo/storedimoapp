<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Traits\MetodosTrait;
use GuzzleHttp\Client;
use Exception;

class CheckDiasPlanAlert
{
    use MetodosTrait;

    public function handle(Request $request, Closure $next)
    {
        // 1. Obtener el ID de la Empresa logueada.
        $idEmpresa = Session::get('id_empresa');
        
        if (!$idEmpresa || $idEmpresa == 5) {
            Session::forget('trial_dias_faltantes');
            return $next($request);
        }

        try {
            // 2. Consultar el estado de la suscripción.
            $estadoSuscripcionEmpresa = $this->consultarEstadoSuscripcionEmpresa($idEmpresa);

            $estadoArray = (array) $estadoSuscripcionEmpresa;
            
            // =========================================================================
            // === CAMBIO CLAVE: AHORA INCLUYE ESTADO 1 (ACTIVO) Y ESTADO 10 (TRIAL) ===
            // =========================================================================
            $estadosConVencimiento = [1, 10]; // 1 = Activo, 10 = Trial
            $estadoActual = $estadoSuscripcionEmpresa->id_estado_suscripcion ?? null;

            // Si no hay suscripción, o el estado no es Activo (1) ni Trial (10), limpiamos y salimos.
            if (empty($estadoArray) || !in_array($estadoActual, $estadosConVencimiento)) {
                Session::forget('trial_dias_faltantes');
                return $next($request);
            }

            // 3. Recalcular los días restantes
            $fechaFinalSuscripcion = $estadoSuscripcionEmpresa->fecha_final;

            if ($fechaFinalSuscripcion) {
                $fechaVencimiento = Carbon::parse($fechaFinalSuscripcion)->endOfDay();
                $diasFaltantes = now()->diffInDays($fechaVencimiento, false);
                
                if ($diasFaltantes >= 0) {
                    // El plan (Activo o Trial) está VIGENTE o vence hoy.
                    Session::put('trial_dias_faltantes', $diasFaltantes);
                } else {
                    // El plan ya venció (diasFaltantes < 0).
                    // Limpiamos la alerta. En el LoginStore, ya manejamos la denegación de acceso.
                    Session::forget('trial_dias_faltantes');
                    
                    // Opcional: Si el estado es 1 o 10 y venció, podrías actualizarlo a Inactivo (2) aquí.
                    // if ($estadoActual != 2) {
                    //    $this->actualizarEstadoSuscripcion($estadoSuscripcionEmpresa->id_suscripcion, 2);
                    // }
                }
            } else {
                // Si el estado es 1 o 10 pero no tiene fecha final (ej. suscripción indefinida, aunque es raro)
                // Limpiamos la alerta.
                Session::forget('trial_dias_faltantes');
            }

        } catch (\Exception $e) {
            // Manejo de errores de conexión/API
            Session::forget('trial_dias_faltantes');
            // Opcional: Log::error("Error en Middleware CheckDiasPlanAlert: " . $e->getMessage());
        }

        return $next($request); // Continúa con la solicitud.
    }

    // Nota: Si este método ya existe en MetodosTrait, bórralo de aquí.
    private function consultarEstadoSuscripcionEmpresa($idEmpresa)
    {
        try {
            // Realiza la solicitud GET a la API
            $client = new Client(['base_uri' => env('BASE_URI')]);

            $response = $client->get('administracion/suscripcion_empresa_estado_login/'.$idEmpresa, [
                    'query' => []
                ]
            );
            return json_decode($response->getBody()->getContents());

        } catch (Exception $e) {
            // Como esto es un middleware, NO podemos redirigir al login ni mostrar alertas SweetAlert (afecta la respuesta HTTP)
            // Solo debemos registrar el error y devolver null o un objeto vacío.
            \Illuminate\Support\Facades\Log::error('Error consultando suscripción en Middleware: ' . $e->getMessage());
            return null; // Devuelve null para que el try/catch principal lo capture.
        }
    }
}
