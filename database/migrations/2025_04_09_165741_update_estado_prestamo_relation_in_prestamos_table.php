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
        // Schema::table('prestamos', function (Blueprint $table) {
        //     // Eliminar la clave foránea antigua
        //     $table->dropForeign(['id_estado_prestamo']);

        //     // Crear la nueva clave foránea
        //     $table->foreign('id_estado_prestamo')->references('id_estado')->on('estados');
        // });

        if (Schema::hasTable('prestamos') && Schema::hasColumn('prestamos', 'id_estado_prestamo')) {
            Schema::table('prestamos', function (Blueprint $table) {
                // Intentar eliminar la FK solo si existe
                try {
                    $table->dropForeign(['id_estado_prestamo']);
                } catch (\Exception $e) {
                    // Ignorar si no existía la FK
                }

                // Crear la nueva FK si la tabla destino existe
                if (Schema::hasTable('estados') && Schema::hasColumn('estados', 'id_estado')) {
                    $table->foreign('id_estado_prestamo')
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
        Schema::table('prestamos', function (Blueprint $table) {
            // Eliminar la clave foránea nueva
            // $table->dropForeign(['id_estado_prestamo']);

            // // Restaurar la relación original
            // $table->foreign('id_estado_prestamo')->references('id_estado_prestamo')->on('estados_prestamo');

            if (Schema::hasTable('prestamos') && Schema::hasColumn('prestamos', 'id_estado_prestamo')) {
                Schema::table('prestamos', function (Blueprint $table) {
                    // Eliminar la FK actual si existe
                    try {
                        $table->dropForeign(['id_estado_prestamo']);
                    } catch (\Exception $e) {
                        // Ignorar si no existía la FK
                    }
    
                    // Restaurar FK original si la tabla destino existe
                    if (Schema::hasTable('estados_prestamo') && Schema::hasColumn('estados_prestamo', 'id_estado_prestamo')) {
                        $table->foreign('id_estado_prestamo')
                            ->references('id_estado_prestamo')
                            ->on('estados_prestamo');
                    }
                });
            }
        });
    }
};
