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
        if (Schema::hasTable('bajas') && Schema::hasColumn('bajas', 'id_estado_baja')) {
            Schema::table('bajas', function (Blueprint $table) {
                $table->dropForeign(['id_estado_baja']);
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
        if (Schema::hasTable('bajas') && Schema::hasColumn('bajas', 'id_tipo_documento')) {
            Schema::table('bajas', function (Blueprint $table) {
                $table->foreign('id_estado_baja')->references('id_estado')->on('estados');
            });
        }
    }
};
