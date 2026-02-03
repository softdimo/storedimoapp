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
        // Verificamos que la tabla exista antes de intentar modificarla
        if (Schema::hasTable('usuarios')) {
            Schema::table('usuarios', function (Blueprint $table) {
                // Solo añadimos la columna si no existe previamente
                if (!Schema::hasColumn('usuarios', 'session_token')) {
                    $table->string('session_token', 100)->nullable()->after('clave');
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
        if (Schema::hasTable('usuarios')) {
            Schema::table('usuarios', function (Blueprint $table) {
                if (Schema::hasColumn('usuarios', 'session_token')) {
                    $table->dropColumn('session_token');
                }
            });
        }
    }
};
