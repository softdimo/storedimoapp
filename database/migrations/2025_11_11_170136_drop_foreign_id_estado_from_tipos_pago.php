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
        if (Schema::hasTable('tipos_pago') && Schema::hasColumn('tipos_pago', 'id_estado')) {
            Schema::table('tipos_pago', function (Blueprint $table) {
                $table->dropForeign(['id_estado']);
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
        if (Schema::hasTable('tipos_pago') && Schema::hasColumn('tipos_pago', 'id_estado')) {
            Schema::table('tipos_pago', function (Blueprint $table) {
                $table->foreign('id_estado')->references('id_estado')->on('estados');
            });
        }
    }
};
