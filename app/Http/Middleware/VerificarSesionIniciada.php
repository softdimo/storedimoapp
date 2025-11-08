<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\DatabaseConnectionHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VerificarSesionIniciada
{
    public function handle($request, Closure $next)
    {
        // 1. Verificación de sesión
        if (!session('sesion_iniciada')) {
            return $this->responderError('No autenticado', 401, $request);
        }

        // 2. Verificación de empresa
        if (!session('empresa_actual')) {
            $this->limpiarSesion();
            return $this->responderError('Sesión inválida', 401, $request);
        }

        try {
            // 3. Verificar permisos desde la BD principal
            $permisos = DB::connection('mysql')
                ->table('model_has_permissions')
                ->join('permissions', 'model_has_permissions.permission_id', '=', 'permissions.id')
                ->where('model_has_permissions.model_id', session('id_usuario'))
                ->where('model_has_permissions.model_type', 'App\\Models\\Usuario')
                ->pluck('permissions.name')
                ->toArray();

            // Almacenar permisos en sesión si no existen
            if (!session()->has('permisos')) {
                session(['permisos' => $permisos]);
            }

            // 4. Configuración tenant
            DatabaseConnectionHelper::configurarConexionTenant(session('empresa_actual'));
            DB::connection('tenant')->getPdo();

            return $next($request);

        } catch (\Exception $e) {
            Log::error("Error middleware autenticación: ".$e->getMessage());
            $this->limpiarSesion();
            return $this->responderError('Error de conexión', 500, $request);
        }
    }

    // --- Métodos nuevos/modificados ---
    protected function responderError($mensaje, $codigo, $request)
    {
        if ($request->is('api/*')) {
            return response()->json(['error' => $mensaje], $codigo);
        }
        return redirect()->route('login')->withErrors(['error' => $mensaje]);
    }

    protected function validarPermisosAPI($request)
    {
        $ruta = $request->path();
        $permisos = session('permisos', []);
        
        if (!in_array($ruta, $permisos['rutas_permitidas'] ?? [])) {
            abort(403, 'No autorizado');
        }
    }

    // Mantener igual
    private function limpiarSesion()
    {
        session()->forget(['sesion_iniciada', 'empresa_actual', 'permisos']);
        session()->flush();
    }
}
