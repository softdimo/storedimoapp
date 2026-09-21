<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Compartir el usuario y datos de empresa a todas las vistas desde la Sesión local
        View::composer('*', function ($view) {
            $usuario                    = session('usuario_logueado');
            $logoEmpresaPredeterminado  = asset('imagenes/logo_storedimo.png');

            $view->with([
                'usuarioLogueado' => $usuario,
                'logoEmpresa'     => $usuario->logo_empresa ?? $logoEmpresaPredeterminado,
                'nombreEmpresa'   => session('empresa_actual') ?? $usuario->nombre_empresa ?? '',
            ]);
        });

        // Composer Alerta Trial
        View::composer('*', function ($view) {
            $diasFaltantes = session('trial_dias_faltantes');
            
            if (is_numeric($diasFaltantes)) {
                $mensaje = "Su plan vence en {$diasFaltantes} días.";
                $view->with('alertaTrial', $mensaje);
            }
        });
    }
} // FIN class AppServiceProvider
