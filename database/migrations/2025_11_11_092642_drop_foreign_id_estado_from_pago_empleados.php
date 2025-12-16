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
        if (Schema::hasTable('pago_empleados') && Schema::hasColumn('pago_empleados', 'id_estado')) {
            Schema::table('pago_empleados', function (Blueprint $table) {
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
        if (Schema::hasTable('pago_empleados') && Schema::hasColumn('pago_empleados', 'id_estado')) {
            Schema::table('pago_empleados', function (Blueprint $table) {
                $table->foreign('id_estado')->references('id_estado')->on('estados');
            });
        }
    }
};
