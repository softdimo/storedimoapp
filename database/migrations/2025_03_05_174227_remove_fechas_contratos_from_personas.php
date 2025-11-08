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
        if (Schema::hasTable('personas')) {
            Schema::table('personas', function (Blueprint $table) {
                if (Schema::hasColumn('personas', 'fecha_contrato')) {
                    $table->dropColumn('fecha_contrato');
                }

                if (Schema::hasColumn('personas', 'fecha_terminacion_contrato')) {
                    $table->dropColumn('fecha_terminacion_contrato');
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
        if (Schema::hasTable('personas')) {
            Schema::table('personas', function (Blueprint $table) {
                if (!Schema::hasColumn('personas', 'fecha_contrato')) {
                    $table->date('fecha_contrato')->nullable()->after('id_estado');
                }

                if (!Schema::hasColumn('personas', 'fecha_terminacion_contrato')) {
                    $table->date('fecha_terminacion_contrato')->nullable()->after('fecha_contrato');
                }
            });
        }
    }
};
