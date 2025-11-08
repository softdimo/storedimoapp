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
        // Schema::table('productos', function (Blueprint $table) {
        //     $table->date('fecha_vencimiento')->nullable()->after('referencia');
        // });

        if (Schema::hasTable('productos') && !Schema::hasColumn('productos', 'fecha_vencimiento')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->date('fecha_vencimiento')->nullable()->after('referencia');
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
        // Schema::table('productos', function (Blueprint $table) {
        //     $table->dropColumn('fecha_vencimiento');
        // });

        if (Schema::hasTable('productos') && Schema::hasColumn('productos', 'fecha_vencimiento')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('fecha_vencimiento');
            });
        }
    }
};
