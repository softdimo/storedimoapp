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
        if (Schema::hasTable('usuarios')) {
            Schema::table('usuarios', function (Blueprint $table) {
                
                if (!Schema::hasColumn('usuarios', 'id_tipo_persona')) {
                    $table->unsignedInteger('id_tipo_persona')->nullable()->after('id_usuario');
                    $table->foreign('id_tipo_persona')->references('id_tipo_persona')->on('tipo_persona');
                }

                if (!Schema::hasColumn('usuarios', 'numero_telefono')) {
                    $table->string('numero_telefono')->nullable()->after('identificacion');
                }

                if (!Schema::hasColumn('usuarios', 'celular')) {
                    $table->string('celular')->nullable()->after('numero_telefono');
                }

                if (!Schema::hasColumn('usuarios', 'id_genero')) {
                    $table->unsignedInteger('id_genero')->nullable()->after('celular');
                    $table->foreign('id_genero')->references('id_genero')->on('generos');
                }

                if (!Schema::hasColumn('usuarios', 'direccion')) {
                    $table->string('direccion')->nullable()->after('email');
                }

                if (!Schema::hasColumn('usuarios', 'fecha_contrato')) {
                    $table->date('fecha_contrato')->nullable()->after('direccion');
                }

                if (!Schema::hasColumn('usuarios', 'fecha_terminacion_contrato')) {
                    $table->date('fecha_terminacion_contrato')->nullable()->after('fecha_contrato');
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

                if (Schema::hasColumn('usuarios', 'id_tipo_persona')) {
                    $table->dropForeign(['id_tipo_persona']);
                    $table->dropColumn('id_tipo_persona');
                }

                if (Schema::hasColumn('usuarios', 'id_genero')) {
                    $table->dropForeign(['id_genero']);
                    $table->dropColumn('id_genero');
                }

                foreach ([
                    'numero_telefono',
                    'celular',
                    'direccion',
                    'fecha_contrato',
                    'fecha_terminacion_contrato'
                ] as $columna) {
                    if (Schema::hasColumn('usuarios', $columna)) {
                        $table->dropColumn($columna);
                    }
                }
            });
        }
    }
};
