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
        if (!Schema::hasTable('empresas'))
        {
            Schema::create('empresas', function (Blueprint $table) {
                $table->increments('id_empresa');
                $table->string('nit_empresa')->nullable();
                $table->string('nombre_empresa')->nullable();
                $table->string('telefono_empresa')->nullable();
                $table->string('celular_empresa')->nullable();
                $table->string('email_empresa')->nullable();
                $table->string('direccion_empresa')->nullable();
                $table->unsignedInteger('id_estado')->nullable();
                $table->timestamps();
                $table->softDeletes();

                if (Schema::hasTable('estados'))
                {
                    $table->foreign('id_estado')->references('id_estado')->on('estados');
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
        if (Schema::hasTable('empresas'))
        {
            Schema::dropIfExists('empresas');
        }
    }
};
