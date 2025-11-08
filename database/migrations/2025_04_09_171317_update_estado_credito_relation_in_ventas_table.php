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
        // Schema::table('ventas', function (Blueprint $table) {
        //     // Eliminar la clave foránea antigua
        //     $table->dropForeign(['id_estado_credito']);

        //     // Crear la nueva clave foránea
        //     $table->foreign('id_estado_credito')->references('id_estado')->on('estados');
        // });

        if (Schema::hasTable('ventas') && Schema::hasColumn('ventas', 'id_estado_credito')) {
            Schema::table('ventas', function (Blueprint $table) {
                // Intentar eliminar la FK antigua si existe
                try {
                    $table->dropForeign(['id_estado_credito']);
                } catch (\Exception $e) {
                    // Ignorar si no existía
                }

                // Crear la nueva FK solo si la tabla y columna destino existen
                if (Schema::hasTable('estados') && Schema::hasColumn('estados', 'id_estado')) {
                    $table->foreign('id_estado_credito')
                        ->references('id_estado')
                        ->on('estados');
                }
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
        // Schema::table('ventas', function (Blueprint $table) {
        //     // Eliminar la clave foránea nueva
        //     $table->dropForeign(['id_estado_credito']);

        //     // Restaurar la relación original
        //     $table->foreign('id_estado_credito')->references('id_estado_credito')->on('estados_credito');
        // });

        if (Schema::hasTable('ventas') && Schema::hasColumn('ventas', 'id_estado_credito')) {
            Schema::table('ventas', function (Blueprint $table) {
                // Intentar eliminar la FK nueva si existe
                try {
                    $table->dropForeign(['id_estado_credito']);
                } catch (\Exception $e) {
                    // Ignorar si no existía
                }

                // Restaurar la FK original si la tabla y columna destino existen
                if (Schema::hasTable('estados_credito') && Schema::hasColumn('estados_credito', 'id_estado_credito')) {
                    $table->foreign('id_estado_credito')
                        ->references('id_estado_credito')
                        ->on('estados_credito');
                }
            });
        }
    }
};
