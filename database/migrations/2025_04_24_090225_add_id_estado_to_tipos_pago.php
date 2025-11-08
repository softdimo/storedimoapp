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
        // Schema::table('tipos_pago', function (Blueprint $table) {
        //     $table->unsignedInteger('id_estado')->nullable()->after('tipo_pago');

        //     $table->foreign('id_estado')->references('id_estado')->on('estados');
        // });

        if (Schema::hasTable('tipos_pago') && !Schema::hasColumn('tipos_pago', 'id_estado')) {
            Schema::table('tipos_pago', function (Blueprint $table) {
                $table->unsignedInteger('id_estado')->nullable()->after('tipo_pago');

                if (Schema::hasTable('estados')) {
                    $table->foreign('id_estado')->references('id_estado')->on('estados');
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
        // Schema::table('tipos_pago', function (Blueprint $table) {
        //     $table->dropColumn('id_estado');
        // });

        if (Schema::hasTable('tipos_pago') && Schema::hasColumn('tipos_pago', 'id_estado')) {
            Schema::table('tipos_pago', function (Blueprint $table) {
                // Primero quitamos la foreign si existe
                try {
                    $table->dropForeign(['id_estado']);
                } catch (\Exception $e) {
                    // Si no existe la foreign, no pasa nada
                }

                // Luego eliminamos la columna
                $table->dropColumn('id_estado');
            });
        }
    }
};
