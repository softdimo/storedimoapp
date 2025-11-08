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
        if (!Schema::hasTable('usuarios')) {
            Schema::create('usuarios', function (Blueprint $table) {
                $table->increments('id_usuario');
                $table->string('nombre_usuario')->nullable();
                $table->string('apellido_usuario')->nullable();
                $table->string('usuario')->nullable();
                $table->string('identificacion')->nullable();
                $table->string('clave')->nullable();
                $table->unsignedInteger('id_estado')->nullable();
                $table->unsignedInteger('id_rol')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('id_estado')->references('id_estado')->on('estados');
                $table->foreign('id_rol')->references('id')->on('roles');
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
            Schema::dropIfExists('usuarios');
        }
    }
};
