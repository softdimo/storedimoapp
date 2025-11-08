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
            Schema::table('compras', function (Blueprint $table) {
                if (!Schema::hasColumn('compras', 'id_producto')) {
                    $table->unsignedInteger('id_producto')->nullable()->after('id_proveedor');

                    if (Schema::hasTable('productos')) {
                        $table->foreign('id_producto')
                              ->references('id_producto')
                              ->on('productos');
                    }
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
        if (Schema::hasTable('compras')) {
            Schema::table('compras', function (Blueprint $table) {
                if (Schema::hasColumn('compras', 'id_producto')) {
                    $table->dropForeign(['id_producto']);
                    $table->dropColumn('id_producto');
                }
            });
        }
    }
};
