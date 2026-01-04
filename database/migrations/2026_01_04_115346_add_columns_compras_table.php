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
        if (Schema::hasTable('compras')) {
            if (!Schema::hasColumn('compras', 'fecha_anulacion_compra')) {
                Schema::table('compras', function (Blueprint $table) {
                    $table->integer('fecha_anulacion_compra')->nullable()->after('motivo_anulacion');
                });
            }
    
            if (!Schema::hasColumn('compras', 'usuario_anulacion')) {
                Schema::table('compras', function (Blueprint $table)
                {
                    $table->integer('usuario_anulacion')->unsigned()->nullable()->after('fecha_anulacion_compra');

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
        if (Schema::hasTable('compras')) {
            if (Schema::hasColumn('compras', 'fecha_anulacion_compra'))
            {
                Schema::table('compras', function (Blueprint $table){
                    $table->dropColumn('fecha_anulacion_compra');
                });
            }

            if (Schema::hasColumn('compras', 'usuario_anulacion'))
            {
                Schema::table('compras', function (Blueprint $table) {
                    
                    $table->dropForeign(['usuario_anulacion']);
                    $table->dropColumn('usuario_anulacion');
                });
            }
        }
    }
};
