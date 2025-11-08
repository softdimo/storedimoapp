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
        // Schema::table('bajas_detalle', function (Blueprint $table) {
        //     $table->string('observaciones')->nullable()->after('cantidad');
        // });

        if (Schema::hasTable('bajas_detalle') && !Schema::hasColumn('bajas_detalle', 'observaciones')) {
            Schema::table('bajas_detalle', function (Blueprint $table) {
                $table->string('observaciones')->nullable()->after('cantidad');
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
        // Schema::table('bajas_detalle', function (Blueprint $table) {
        //     $table->dropColumn('observaciones');
        // });

        if (Schema::hasTable('bajas_detalle') && Schema::hasColumn('bajas_detalle', 'observaciones')) {
            Schema::table('bajas_detalle', function (Blueprint $table) {
                $table->dropColumn('observaciones');
            });
        }
    }
};
