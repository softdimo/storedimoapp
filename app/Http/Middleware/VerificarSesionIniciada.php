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
        if (!session('datos_empresa') || !session('empresa_actual')) {
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

            if (!session()->has('permisos')) {
                session(['permisos' => $permisos]);
            }

            // 4. Configuración tenant
            DatabaseConnectionHelper::configurarConexionTenant(session('datos_empresa'));
            DB::connection('tenant')->getPdo();

            return $next($request);

        } catch (\Exception $e) {
            // Importante: NO limpiar sesión por fallos temporales de BD/API en Hostinger.
            // Antes esto hacía Session::flush() y parecía un "logout" al entrar a /usuarios.
            Log::error('Error middleware autenticación: '.$e->getMessage(), [
                'usuario' => session('id_usuario'),
                'ruta'    => $request->path(),
            ]);

            if ($request->is('api/*')) {
                return response()->json(['error' => 'Error de conexión'], 500);
            }

            alert()->error('Error de conexión', 'No se pudo validar la sesión con la base de datos. Intente de nuevo.');
            return redirect()->route('home.index');
        }
    }

    protected function responderError($mensaje, $codigo, $request)
    {
        if ($request->is('api/*')) {
            return response()->json(['error' => $mensaje], $codigo);
        }
        return redirect()->route('login')->withErrors(['error' => $mensaje]);
    }

    private function limpiarSesion()
    {
        session()->forget(['sesion_iniciada', 'empresa_actual', 'datos_empresa', 'permisos']);
        session()->flush();
    }
}
