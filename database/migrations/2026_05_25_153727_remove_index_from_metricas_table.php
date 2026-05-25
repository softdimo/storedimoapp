<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RemoveIndexFromMetricasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Validamos la conexión principal 'mysql' y la tabla
        if (Schema::connection('mysql')->hasTable('traffic_logs')) {
            
            // Obtenemos los índices actuales para verificar si existe
            $schemaManager = DB::connection('mysql')->getDoctrineSchemaManager();
            $indexes = $schemaManager->listTableIndexes('traffic_logs');

            // Si el índice SÍ existe en el 'up', lo eliminamos de una vez
            if (array_key_exists('idx_metrica_created_at', $indexes)) {
                Schema::connection('mysql')->table('traffic_logs', function (Blueprint $table) {
                    $table->dropIndex('idx_metrica_created_at');
                });
            }
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
            
            $schemaManager = DB::connection('mysql')->getDoctrineSchemaManager();
            $indexes = $schemaManager->listTableIndexes('traffic_logs');

            // El 'down' (revertir) volvería a crear el índice si no existía
            if (!array_key_exists('idx_metrica_created_at', $indexes)) {
                Schema::connection('mysql')->table('traffic_logs', function (Blueprint $table) {
                    $table->index('created_at', 'idx_metrica_created_at');
                });
            }
        }
    }
}
