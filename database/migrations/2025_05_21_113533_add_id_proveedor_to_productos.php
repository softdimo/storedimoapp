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
        //     $table->unsignedInteger('id_proveedor')->nullable()->after('id_persona');

        //     $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedores');
        // });

        if (Schema::hasTable('productos')) {
            Schema::table('productos', function (Blueprint $table) {
                if (!Schema::hasColumn('productos', 'id_proveedor')) {
                    $table->unsignedInteger('id_proveedor')->nullable()->after('id_persona');

                    if (Schema::hasTable('proveedores')) {
                        $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedores');
                    }
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
        // Schema::table('productos', function (Blueprint $table) {
        //     $table->dropColumn('id_proveedor');
        // });

        if (Schema::hasTable('productos') && Schema::hasColumn('productos', 'id_proveedor')) {
            Schema::table('productos', function (Blueprint $table) {
                // Primero eliminamos la foreign key
                $table->dropForeign(['id_proveedor']);
                // Luego eliminamos la columna
                $table->dropColumn('id_proveedor');
            });
        }
    }
};
