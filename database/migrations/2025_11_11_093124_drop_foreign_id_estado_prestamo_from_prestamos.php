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
        if (Schema::hasTable('prestamos') && Schema::hasColumn('prestamos', 'id_estado_prestamo')) {
            Schema::table('prestamos', function (Blueprint $table) {
                $table->dropForeign(['id_estado_prestamo']);
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
        if (Schema::hasTable('prestamos') && Schema::hasColumn('prestamos', 'id_estado_prestamo')) {
            Schema::table('prestamos', function (Blueprint $table) {
                $table->foreign('id_estado_prestamo')->references('id_estado')->on('estados');
            });
        }
    }
};
