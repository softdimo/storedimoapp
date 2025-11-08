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
        // Schema::create('informexcampo', function (Blueprint $table)
        // {
        //     $table->increments('id');
        //     $table->integer('informe_codigo');
        //     $table->string('informe_descripcion');
        //     $table->text('select_sql');
        //     $table->text('join_sql')->nullable();
        //     $table->text('where_sql')->nullable();
        //     $table->boolean('campo_requerido')->default(1);
        //     $table->integer('campo_tipo')->default(1);
        //     $table->integer('campo_agrupar')->default(1);
        //     $table->integer('campo_orden');
        //     $table->text('campo_adicional');
        //     $table->boolean('campo_filtro');
        //     $table->integer('filtro_orden');
        //     $table->integer('filtro_tipo');
        //     $table->text('filtro_atributos');
        //     $table->text('filtro_value');
        //     $table->text('filtro_sql');
        //     $table->string('option_value');
        //     $table->string('option_contenido');
        //     $table->string('campo_filtro_where');
        //     $table->text('campo_join_adicionales');
        //     $table->text('campo_link');
        //     $table->boolean('estado_campo')->default(1);
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        if (!Schema::hasTable('informexcampo')) {
            Schema::create('informexcampo', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('informe_codigo');
                $table->string('informe_descripcion');
                $table->text('select_sql');
                $table->text('join_sql')->nullable();
                $table->text('where_sql')->nullable();
                $table->boolean('campo_requerido')->default(1);
                $table->integer('campo_tipo')->default(1);
                $table->integer('campo_agrupar')->default(1);
                $table->integer('campo_orden');
                $table->text('campo_adicional');
                $table->boolean('campo_filtro');
                $table->integer('filtro_orden');
                $table->integer('filtro_tipo');
                $table->text('filtro_atributos');
                $table->text('filtro_value');
                $table->text('filtro_sql');
                $table->string('option_value');
                $table->string('option_contenido');
                $table->string('campo_filtro_where');
                $table->text('campo_join_adicionales');
                $table->text('campo_link');
                $table->boolean('estado_campo')->default(1);
                $table->timestamps();
                $table->softDeletes();
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
        // Schema::dropIfExists('informexcampo');

        if (Schema::hasTable('informexcampo')) {
            Schema::dropIfExists('informexcampo');
        }
    }
};
