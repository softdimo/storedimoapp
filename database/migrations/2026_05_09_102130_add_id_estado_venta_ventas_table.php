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
            if (!Schema::hasColumn('ventas', 'id_estado_venta')) {
                
                Schema::table('ventas', function (Blueprint $table) {
                    $table->unsignedInteger('id_estado_venta')->nullable()->after('id_estado_credito');
                });

                Schema::table('ventas', function (Blueprint $table) {
                    // 2. Crear la foránea por separado
                    $table->foreign('id_estado_venta')->references('id_estado')->on('estados');
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
            if (Schema::hasColumn('ventas', 'id_estado_venta'))
            {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->dropForeign(['id_estado_venta']);
                    $table->dropColumn('id_estado_venta');
                });
            }
        }
    }
};
