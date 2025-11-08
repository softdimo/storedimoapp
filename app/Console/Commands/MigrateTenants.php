<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;

class MigrateTenants extends Command
{
    /**
     * El nombre y firma del comando.
     *
     * @var string
     */
    // protected $signature = 'migrate:tenants {--path=}';
    protected $signature = 'migrate:tenants {--path=} {--only=}';

    /**
     * La descripción del comando.
     *
     * @var string
     */
    protected $description = 'Ejecuta migraciones en la base principal y en todas las bases de datos de empresas';

    /**
     * Ejecutar el comando.
     */
    public function handle()
    {
        // Traemos todas las empresas desde la BD principal (storedimo incluida)
        $empresas = Empresa::on('mysql')->get();

        // Si pasamos --only, filtramos solo esa BD
        if ($this->option('only')) {
            $empresas = $empresas->filter(function ($empresa) {
                return Crypt::decrypt($empresa->db_database) === $this->option('only');
            });
        }

        foreach ($empresas as $empresa) {
            // Desencriptar credenciales
            $host     = Crypt::decrypt($empresa->db_host);
            $database = Crypt::decrypt($empresa->db_database);
            $username = Crypt::decrypt($empresa->db_username);
            $password = Crypt::decrypt($empresa->db_password);


            $this->info("Migrando: {$empresa->nombre_empresa} ({$database})");

            // Configuración dinámica de conexión
            config([
                'database.connections.tenant' => [
                    'driver'    => 'mysql',
                    'host'      => $host,
                    'port'      => 3306,
                    'database'  => $database,
                    'username'  => $username,
                    'password'  => $password,
                    'charset'   => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                ]
            ]);

            // 🔴 Esto es clave para que no use la conexión cacheada
            DB::purge('tenant');
            DB::reconnect('tenant');

            // Opciones de migración
            $options = [
                '--database' => 'tenant',
            ];
            
            if ($this->option('path')) {
                $options['--path'] = $this->option('path');
            }
            
            $this->call('migrate', $options);
        }

        $this->info('✅ Migraciones completadas en todas las bases (ppal + tenants)');
    }
}
