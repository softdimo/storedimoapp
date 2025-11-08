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
    // public function up()
    // {
    //     Schema::table('productos', function (Blueprint $table) {
    //         $table->unsignedInteger('id_umd')->nullable()->after('id_categoria');

    //         $table->foreign('id_umd')->references('id')->on('unidades_medida');
    //     });
    // }

    public function up()
    {
        if (Schema::hasTable('productos') && !Schema::hasColumn('productos', 'id_umd')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->unsignedInteger('id_umd')->nullable()->after('id_categoria');

                $table->foreign('id_umd')->references('id')->on('unidades_medida');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::table('productos', function (Blueprint $table) {
    //         $table->dropColumn('id_umd');
    //     });
    // }

    public function down()
    {
        if (Schema::hasTable('productos') && Schema::hasColumn('productos', 'id_umd')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('id_umd');
            });
        }
    }
};
