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
        //     $table->longText('imagen_producto')->nullable()->after('id_tipo_persona');
        // });

        if (Schema::hasTable('productos') && !Schema::hasColumn('productos', 'imagen_producto')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->longText('imagen_producto')->nullable()->after('id_tipo_persona');
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
        //     $table->dropColumn('imagen_producto');
        // });

        if (Schema::hasTable('productos') && Schema::hasColumn('productos', 'imagen_producto')) {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('imagen_producto');
            });
        }
    }
};
