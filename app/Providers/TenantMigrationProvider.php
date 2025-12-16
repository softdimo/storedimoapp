<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;
use Exception;
use Illuminate\Support\Facades\Log;
class TenantMigrationProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
         // Solo ejecuta si estamos migrando
         if ($this->app->runningInConsole() && $this->isMigrating())
         {
            $this->runTenantMigrations();
        }
    }

    protected function isMigrating(): bool
    {
        $args = $_SERVER['argv'] ?? [];
        return in_array('migrate', $args);
    }

    protected function runTenantMigrations()
    {
        $tenants = Empresa::where('id_estado', 1)
                    ->get();

        foreach ($tenants as $tenant)
        {
            // 1. Limpiar conexión anterior
            Config::set('database.connections.tenant', null);
            DB::purge('tenant');

            if ($this->app->runningInConsole())
            {
                echo "Migrando tenant: " . Crypt::decrypt($tenant->db_database) . "\n";
            }

            try
            {
                // 1️⃣ Desencriptar datos
                $dbHost = Crypt::decrypt($tenant->db_host);
                $dbDatabase = Crypt::decrypt($tenant->db_database);
                $dbUsername = Crypt::decrypt($tenant->db_username);
                $dbPassword = Crypt::decrypt($tenant->db_password);

                // 2️⃣ Si estamos en entorno local y el host es "localhost", usar el host público
                if (app()->environment('local') && $dbHost === 'localhost') {
                    $dbHost = 'srv1999.hstgr.io';
                    Log::info("🔁 Host ajustado automáticamente para entorno local: {$dbHost}");
                }

                // 3️⃣ Configurar conexión tenant
                Config::set('database.connections.tenant', [
                    'driver' => 'mysql',
                    'host' => $dbHost,
                    'port' => env('DB_PORT', '3306'),
                    'database' => $dbDatabase,
                    'username' => $dbUsername,
                    'password' => $dbPassword,
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix'    => '',
                    'strict'    => true,
                    'engine'    => null,
                    'options'   => [
                        \PDO::ATTR_PERSISTENT => false,
                    ]
                ]);

                // 4. Establecer conexión tenant
                DB::purge('tenant');
                Log::info('Reconectando a la conexión tenant');
                DB::reconnect('tenant');

                // 5. Verificar conexión
                DB::connection('tenant')->getPdo();

                // 6. Establecer como conexión default
                Config::set('database.default', 'tenant');
                DB::reconnect('tenant');
                
            } catch (Exception $e)
            {
                echo "Error desencriptando datos de {$tenant->nombre_empresa}: " . $e->getMessage() . "\n";
                continue;
            }

            // Verifica si la base está accesible
            try
            {
                Schema::connection('tenant')->hasTable('migrations');
            } catch (Exception $e)
            {
                echo "Error conectando a " . Crypt::decrypt($tenant->db_database) . ": " . $e->getMessage() . "\n";
                continue;
            }

            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => 'database/migrations',
                '--force' => true,
            ]);

            echo Artisan::output();
        }
    }
}
