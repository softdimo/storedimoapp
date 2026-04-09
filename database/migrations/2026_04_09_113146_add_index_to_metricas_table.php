<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToMetricasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Validamos la conexión principal y que la tabla exista
        if (Schema::connection('mysql')->hasTable('traffic_logs')) {
            Schema::connection('mysql')->table('traffic_logs', function (Blueprint $table) {
                // Creamos el índice sobre el campo created_at
                $table->index('created_at', 'idx_metrica_created_at');
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
        if (Schema::connection('mysql')->hasTable('traffic_logs')) {
            Schema::connection('mysql')->table('traffic_logs', function (Blueprint $table) {
                // Eliminamos el índice creado
                $table->dropIndex('idx_metrica_created_at');
            });
        }
    }
}