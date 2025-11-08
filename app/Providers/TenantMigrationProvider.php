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
                Config::set('database.connections.tenant', [
                    'driver' => 'mysql',
                    'host' =>  Crypt::decrypt($tenant->db_host),
                    'port' => env('DB_PORT', '3306'),
                    'database' => Crypt::decrypt($tenant->db_database),
                    'username' => Crypt::decrypt($tenant->db_username),
                    'password' => Crypt::decrypt($tenant->db_password),
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
