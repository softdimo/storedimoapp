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
        if (Schema::hasTable('ventas')) {

            if (!Schema::hasColumn('ventas', 'motivo_anulacion')) {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->string('motivo_anulacion')->nullable()->after('id_estado_venta');
                });
            }

            if (!Schema::hasColumn('ventas', 'fecha_anulacion_venta')) {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->integer('fecha_anulacion_venta')->nullable()->after('motivo_anulacion');
                });
            }
    
            if (!Schema::hasColumn('ventas', 'usuario_anulacion')) {
                Schema::table('ventas', function (Blueprint $table)
                {
                    $table->integer('usuario_anulacion')->unsigned()->nullable()->after('fecha_anulacion_venta');

                    $table->foreign('usuario_anulacion')->references('id_usuario')->on('usuarios')
                        ->onDelete('set null');
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
        if (Schema::hasTable('ventas')) {
            if (Schema::hasColumn('ventas', 'motivo_anulacion'))
            {
                Schema::table('ventas', function (Blueprint $table){
                    $table->dropColumn('motivo_anulacion');
                });
            }

            if (Schema::hasColumn('ventas', 'fecha_anulacion_venta'))
            {
                Schema::table('ventas', function (Blueprint $table){
                    $table->dropColumn('fecha_anulacion_venta');
                });
            }

            if (Schema::hasColumn('ventas', 'usuario_anulacion'))
            {
                Schema::table('ventas', function (Blueprint $table)
                {
                    $table->dropForeign(['usuario_anulacion']);
                    $table->dropColumn('usuario_anulacion');
                });
            }
        }
    }
};
