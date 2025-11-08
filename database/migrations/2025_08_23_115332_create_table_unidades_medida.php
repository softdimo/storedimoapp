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
        // Schema::create('unidades_medida', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('descripcion');
        //     $table->string('abreviatura');
        //     $table->integer('estado_id')->unsigned();
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('estado_id')->references('id_estado')->on('estados');
        // });

        if (!Schema::hasTable('unidades_medida')) {
            Schema::create('unidades_medida', function (Blueprint $table) {
                $table->increments('id');
                $table->string('descripcion');
                $table->string('abreviatura');
                $table->unsignedInteger('estado_id');
                $table->timestamps();
                $table->softDeletes();

                // Crear FK solo si la tabla estados existe
                if (Schema::hasTable('estados')) {
                    $table->foreign('estado_id')
                          ->references('id_estado')
                          ->on('estados');
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
        // Schema::dropIfExists('unidades_medida');

        if (Schema::hasTable('unidades_medida')) {
            Schema::table('unidades_medida', function (Blueprint $table) {
                if (Schema::hasColumn('unidades_medida', 'estado_id')) {
                    // Nombre por convención: unidades_medida_estado_id_foreign
                    $table->dropForeign(['estado_id']);
                }
            });

            Schema::dropIfExists('unidades_medida');
        }
    }
};
