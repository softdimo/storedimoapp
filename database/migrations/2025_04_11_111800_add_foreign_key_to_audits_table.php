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
        // Schema::table('audits', function (Blueprint $table) {
        //     // Cambiar tipo de user_id a INT sin signo
        //     $table->unsignedInteger('user_id')->nullable()->change();

        //     // Agregar la relación con usuarios
        //     $table->foreign('user_id')
        //           ->references('id_usuario')
        //           ->on('usuarios')
        //           ->onDelete('set null');
        // });

        if (Schema::hasTable('audits') && Schema::hasColumn('audits', 'user_id')) {
            Schema::table('audits', function (Blueprint $table) {
                // Cambiar tipo de user_id a INT sin signo
                $table->unsignedInteger('user_id')->nullable()->change();

                // Agregar la relación con usuarios (si existe la tabla usuarios)
                if (Schema::hasTable('usuarios')) {
                    $table->foreign('user_id')
                          ->references('id_usuario')
                          ->on('usuarios')
                          ->onDelete('set null');
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
        // Schema::table('audits', function (Blueprint $table) {
        //     // Eliminar la foreign key
        //     $table->dropForeign(['user_id']);

        //     // Restaurar tipo original si lo necesitás (opcional)
        //     $table->unsignedBigInteger('user_id')->nullable()->change();
        // });

        if (Schema::hasTable('audits') && Schema::hasColumn('audits', 'user_id')) {
            Schema::table('audits', function (Blueprint $table) {
                // Eliminar la foreign key si existe
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // Ignorar si no existe
                }

                // Restaurar tipo original a BIGINT (si aplica)
                $table->unsignedBigInteger('user_id')->nullable()->change();
            });
        }
    }
};
