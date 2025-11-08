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
        if (!Schema::hasTable('personas')) {
            Schema::create('personas', function (Blueprint $table) {
                $table->increments('id_persona');
                $table->unsignedInteger('id_tipo_persona')->nullable();
                $table->unsignedInteger('id_tipo_documento')->nullable();
                $table->string('identificacion')->nullable();
                $table->string('nombres_persona')->nullable();
                $table->string('apellidos_persona')->nullable();
                $table->string('numero_telefono')->nullable();
                $table->string('celular')->nullable();
                $table->string('email')->nullable();
                $table->unsignedInteger('id_genero')->nullable();
                $table->string('direccion')->nullable();
                $table->unsignedInteger('id_estado')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('id_tipo_persona')->references('id_tipo_persona')->on('tipo_persona');
                $table->foreign('id_tipo_documento')->references('id_tipo_documento')->on('tipo_documento');
                $table->foreign('id_genero')->references('id_genero')->on('generos');
                $table->foreign('id_estado')->references('id_estado')->on('estados');
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
        if (Schema::hasTable('personas')) {
            Schema::dropIfExists('personas');
        }
    }
};
