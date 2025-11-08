<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('productos') && Schema::hasColumn('productos', 'id_umd')) {
            // Revisar tipo de columna actual
            $column = DB::selectOne("
                SELECT DATA_TYPE, COLUMN_TYPE 
                FROM information_schema.COLUMNS
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'productos'
                  AND COLUMN_NAME = 'id_umd'
            ");

            if ($column && $column->DATA_TYPE === 'bigint') {
                // Verificar si existe una foreign key sobre productos.id_umd
                $fk = DB::selectOne("
                    SELECT CONSTRAINT_NAME
                    FROM information_schema.KEY_COLUMN_USAGE
                    WHERE TABLE_SCHEMA = DATABASE()
                      AND TABLE_NAME = 'productos'
                      AND COLUMN_NAME = 'id_umd'
                      AND REFERENCED_TABLE_NAME IS NOT NULL
                ");

                if ($fk) {
                    Schema::table('productos', function (Blueprint $table) {
                        $table->dropForeign(['id_umd']);
                    });
                }

                // Cambiar tipo de dato a int(10) unsigned
                Schema::table('productos', function (Blueprint $table) {
                    $table->unsignedInteger('id_umd')->nullable()->change();
                });

                // Restaurar la foreign key
                Schema::table('productos', function (Blueprint $table) {
                    $table->foreign('id_umd')->references('id')->on('unidades_medida');
                });
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('productos') && Schema::hasColumn('productos', 'id_umd')) {
            // Revertir a bigint
            $fk = DB::selectOne("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'productos'
                  AND COLUMN_NAME = 'id_umd'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            if ($fk) {
                Schema::table('productos', function (Blueprint $table) {
                    $table->dropForeign(['id_umd']);
                });
            }

            Schema::table('productos', function (Blueprint $table) {
                $table->unsignedBigInteger('id_umd')->nullable()->change();
            });
        }
    }
};
