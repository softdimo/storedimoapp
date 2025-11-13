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
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'id_tipo_persona')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->dropForeign(['id_tipo_persona']);
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
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'id_tipo_persona')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->foreign('id_tipo_persona')->references('id_tipo_persona')->on('tipo_persona');
            });
        }
    }
};
