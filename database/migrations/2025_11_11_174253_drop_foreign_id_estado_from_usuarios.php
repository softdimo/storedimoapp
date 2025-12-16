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
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'id_estado')) {
            Schema::table('usuarios', function (Blueprint $table) {
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
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'id_estado')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->foreign('id_estado')->references('id_estado')->on('estados');
            });
        }
    }
};
