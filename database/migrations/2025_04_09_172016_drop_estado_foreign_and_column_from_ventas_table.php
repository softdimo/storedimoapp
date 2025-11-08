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
        //     // Eliminar la clave foránea
        //     $table->dropForeign(['id_estado']);

        //     // Eliminar la columna
        //     $table->dropColumn('id_estado');
        // });

        if (Schema::hasTable('ventas') && Schema::hasColumn('ventas', 'id_estado')) {
            Schema::table('ventas', function (Blueprint $table) {
                // Intentar eliminar la FK si existe
                try {
                    $table->dropForeign(['id_estado']);
                } catch (\Exception $e) {
                    // Ignorar si no existía
                }

                // Eliminar la columna
                try {
                    $table->dropColumn('id_estado');
                } catch (\Exception $e) {
                    // Ignorar si ya estaba eliminada
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
        //     $table->unsignedInteger('id_estado')->nullable(); // O solo integer(), según tu schema
        //     $table->foreign('id_estado')->references('id_estado')->on('estados');
        // });

        if (Schema::hasTable('ventas') && !Schema::hasColumn('ventas', 'id_estado')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->unsignedInteger('id_estado')->nullable();

                if (Schema::hasTable('estados') && Schema::hasColumn('estados', 'id_estado')) {
                    $table->foreign('id_estado')
                        ->references('id_estado')
                        ->on('estados');
                }
            });
        }
    }
};
