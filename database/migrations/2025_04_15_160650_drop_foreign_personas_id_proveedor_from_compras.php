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
        // Schema::table('compras', function (Blueprint $table) {
        //     // Quitamos la relación vieja
        //     $table->dropForeign(['id_proveedor']);

        //     // Creamos la nueva relación correcta
        //     $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedores');
        // });

        if (Schema::hasTable('compras') && Schema::hasColumn('compras', 'id_proveedor')) {
            Schema::table('compras', function (Blueprint $table) {
                // Verificar y soltar la relación vieja si existe
                try {
                    $table->dropForeign(['id_proveedor']);
                } catch (\Exception $e) {
                    // Ignorar si no existe la foreign key
                }

                // Crear la relación nueva si existe la tabla proveedores
                if (Schema::hasTable('proveedores')) {
                    $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedores');
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
        // Schema::table('compras', function (Blueprint $table) {
        //      // Quitamos la nueva relación
        //      $table->dropForeign(['id_proveedor']);

        //      // Restauramos la relación anterior
        //      $table->foreign('id_proveedor')->references('id_persona')->on('personas');
        // });

        if (Schema::hasTable('compras') && Schema::hasColumn('compras', 'id_proveedor')) {
            Schema::table('compras', function (Blueprint $table) {
                // Verificar y soltar la relación nueva si existe
                try {
                    $table->dropForeign(['id_proveedor']);
                } catch (\Exception $e) {
                    // Ignorar si no existe la foreign key
                }

                // Restaurar la relación original si existe la tabla personas
                if (Schema::hasTable('personas')) {
                    $table->foreign('id_proveedor')->references('id_persona')->on('personas');
                }
            });
        }
    }
};
