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
        if (Schema::hasTable('productos') && Schema::hasColumn('productos', 'id_estado')) {
            Schema::table('productos', function (Blueprint $table) {
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
        if (Schema::hasTable('productos') && Schema::hasColumn('productos', 'id_estado')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->foreign('id_estado')->references('id_estado')->on('estados');
            });
        }
    }
};
