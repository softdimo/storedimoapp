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
        // Schema::create('bajas', function (Blueprint $table) {
        //     $table->increments('id_baja');
        //     $table->unsignedInteger('id_responsable_baja')->nullable();
        //     $table->dateTime('fecha_baja')->nullable();
        //     $table->unsignedInteger('id_estado_baja')->nullable();

        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('id_responsable_baja')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        //     $table->foreign('id_estado_baja')->references('id_estado')->on('estados')->onDelete('cascade');
        // });

        // Crear tabla solo si no existe
        if (!Schema::hasTable('bajas')) {
            Schema::create('bajas', function (Blueprint $table) {
                $table->increments('id_baja');
                $table->unsignedInteger('id_responsable_baja')->nullable();
                $table->dateTime('fecha_baja')->nullable();
                $table->unsignedInteger('id_estado_baja')->nullable();

                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Validar y agregar FK id_responsable_baja → usuarios.id_usuario
        if (
            Schema::hasTable('bajas') &&
            Schema::hasColumn('bajas', 'id_responsable_baja') &&
            Schema::hasTable('usuarios') &&
            Schema::hasColumn('usuarios', 'id_usuario')
        ) {
            Schema::table('bajas', function (Blueprint $table) {
                // Laravel lanzará error si ya existe, así que aquí deberías haber limpiado antes
                $table->foreign('id_responsable_baja')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            });
        }

        // Validar y agregar FK id_estado_baja → estados.id_estado
        if (
            Schema::hasTable('bajas') &&
            Schema::hasColumn('bajas', 'id_estado_baja') &&
            Schema::hasTable('estados') &&
            Schema::hasColumn('estados', 'id_estado')
        ) {
            Schema::table('bajas', function (Blueprint $table) {
                $table->foreign('id_estado_baja')->references('id_estado')->on('estados')->onDelete('cascade');
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
        // Schema::dropIfExists('bajas');

        if (Schema::hasTable('bajas')) {
            Schema::table('bajas', function (Blueprint $table) {
                // Soltar claves foráneas si existen
                if (Schema::hasColumn('bajas', 'id_responsable_baja')) {
                    $table->dropForeign(['id_responsable_baja']);
                }
                if (Schema::hasColumn('bajas', 'id_estado_baja')) {
                    $table->dropForeign(['id_estado_baja']);
                }
            });

            Schema::dropIfExists('bajas');
        }
    }
};
