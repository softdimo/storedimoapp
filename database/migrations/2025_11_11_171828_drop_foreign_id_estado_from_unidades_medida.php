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
        if (Schema::hasTable('unidades_medida') && Schema::hasColumn('unidades_medida', 'estado_id')) {
            Schema::table('unidades_medida', function (Blueprint $table) {
                $table->dropForeign(['estado_id']);
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
        if (Schema::hasTable('unidades_medida') && Schema::hasColumn('unidades_medida', 'estado_id')) {
            Schema::table('unidades_medida', function (Blueprint $table) {
                $table->foreign('estado_id')->references('id_estado')->on('estados');
            });
        }
    }
};
