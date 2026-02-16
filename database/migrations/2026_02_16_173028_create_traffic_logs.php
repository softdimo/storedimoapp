<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Forzamos la conexión a 'mysql' (la principal)
        // Y validamos que no exista ya en esa base de datos
        if (!Schema::connection('mysql')->hasTable('traffic_logs')) {
            Schema::connection('mysql')->create('traffic_logs', function (Blueprint $table) {
                $table->increments('id_log');
                $table->string('tenant_db')->nullable(); // Para guardar el nombre de la BD tenant
                $table->string('source');                // 'WEB_APP' o 'LUMEN_API'
                $table->string('method', 10);            // GET, POST, PUT, DELETE
                $table->text('path');                    // Usamos text por si la URL es muy larga
                $table->string('ip', 45)->nullable();    // 45 para soportar IPv6
                $table->integer('status_code')->nullable();
                $table->string('user_agent')->nullable(); // Útil para saber si es un bot o navegador
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Importante: También especificar la conexión en el borrado
        if (Schema::connection('mysql')->hasTable('traffic_logs')) {
            Schema::connection('mysql')->dropIfExists('traffic_logs');
        }
    }
};
