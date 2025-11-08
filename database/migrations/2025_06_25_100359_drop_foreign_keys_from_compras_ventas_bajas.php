<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Eliminar clave foránea en compras.id_usuario
        // Schema::table('compras', function (Blueprint $table) {
        //     $table->dropForeign(['id_usuario']); // compras_id_usuario_foreign
        // });

        if (Schema::hasTable('compras')) {
            $foreigns = DB::select("SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'compras'
                  AND COLUMN_NAME = 'id_usuario'");

            if (!empty($foreigns)) {
                Schema::table('compras', function (Blueprint $table) {
                    $table->dropForeign(['id_usuario']);
                });
            }
        }

        // ====================================================================

        // Eliminar clave foránea en ventas.id_usuario
        // Schema::table('ventas', function (Blueprint $table) {
        //     $table->dropForeign(['id_usuario']); // ventas_id_usuario_foreign
        // });

        if (Schema::hasTable('ventas')) {
            $foreigns = DB::select("SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'ventas'
                  AND COLUMN_NAME = 'id_usuario'");

            if (!empty($foreigns)) {
                Schema::table('ventas', function (Blueprint $table) {
                    $table->dropForeign(['id_usuario']);
                });
            }
        }

        // ====================================================================

        // Eliminar clave foránea en bajas.id_responsable_baja
        // Schema::table('bajas', function (Blueprint $table) {
        //     $table->dropForeign(['id_responsable_baja']); // bajas_id_responsable_baja_foreign
        // });

        if (Schema::hasTable('bajas')) {
            $foreigns = DB::select("SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'bajas'
                  AND COLUMN_NAME = 'id_responsable_baja'");

            if (!empty($foreigns)) {
                Schema::table('bajas', function (Blueprint $table) {
                    $table->dropForeign(['id_responsable_baja']);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Restaurar clave foránea en compras.id_usuario
        // Schema::table('compras', function (Blueprint $table) {
        //     $table->foreign('id_usuario')
        //         ->references('id_usuario')
        //         ->on('usuarios')
        //         ->onUpdate('cascade')
        //         ->onDelete('restrict');
        // });

        if (Schema::hasTable('compras') && Schema::hasTable('usuarios')) {
            Schema::table('compras', function (Blueprint $table) {
                $table->foreign('id_usuario')
                    ->references('id_usuario')
                    ->on('usuarios')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            });
        }

        // ====================================================================

        // Restaurar clave foránea en ventas.id_usuario
        // Schema::table('ventas', function (Blueprint $table) {
        //     $table->foreign('id_usuario')
        //         ->references('id_usuario')
        //         ->on('usuarios')
        //         ->onUpdate('cascade')
        //         ->onDelete('restrict');
        // });

        if (Schema::hasTable('ventas') && Schema::hasTable('usuarios')) {
            Schema::table('ventas', function (Blueprint $table) {
                $table->foreign('id_usuario')
                    ->references('id_usuario')
                    ->on('usuarios')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            });
        }

        // ====================================================================

        // Restaurar clave foránea en bajas.id_responsable_baja
        // Schema::table('bajas', function (Blueprint $table) {
        //     $table->foreign('id_responsable_baja')
        //         ->references('id_usuario')
        //         ->on('usuarios')
        //         ->onUpdate('cascade')
        //         ->onDelete('restrict');
        // });

        if (Schema::hasTable('bajas') && Schema::hasTable('usuarios')) {
            Schema::table('bajas', function (Blueprint $table) {
                $table->foreign('id_responsable_baja')
                    ->references('id_usuario')
                    ->on('usuarios')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            });
        }
    }
};
