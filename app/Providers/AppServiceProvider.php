<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Exception;
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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $baseUri = env('BASE_URI');
                $clientApi = new Client(['base_uri' => $baseUri]);
                $idUsuario = session('id_usuario');

                $logoEmpresa = asset('imagenes/logo_storedimo.png');

                if (!$idUsuario) {
                    $view->with('logoEmpresa', $logoEmpresa);
                    return;
                }

                $response = $clientApi->get($baseUri . 'administracion/consulta_usuario_logueado/' . $idUsuario);
                $usuario = json_decode($response->getBody()->getContents());

                $view->with([
                    'usuarioLogueado' => $usuario,
                    'logoEmpresa' => $usuario->logo_empresa ?? $logoEmpresa,
                ]);
            } catch (\Exception $e) {
                $view->with('logoEmpresa', $logoEmpresa);
            }
        });

        // ====================================================================
        // === NUEVO VIEW COMPOSER: Alerta de Días Faltantes del Trial (Demo) ===
        // ====================================================================

        // Aplicado a TODAS las vistas para que esté disponible en cualquier página
        View::composer(['*'], function ($view) {
            $diasFaltantes = session('trial_dias_faltantes');
            
            // Verificamos si la variable de sesión existe y es un número
            if (is_numeric($diasFaltantes)) {
                $mensaje = "Su plan vence en **{$diasFaltantes}** días.";
                $view->with('alertaTrial', $mensaje);
            }
        });
    }
}
