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
        if (Schema::hasTable('ventas') && Schema::hasColumn('ventas', 'id_estado_credito')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->dropForeign(['id_estado_credito']);
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
        if (Schema::hasTable('ventas') && Schema::hasColumn('ventas', 'id_estado_credito')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->foreign('id_estado_credito')->references('id_estado')->on('estados');
            });
        }
    }
};
