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
        // Schema::create('proveedores', function (Blueprint $table) {
        //     $table->increments('id_proveedor');
        //     $table->unsignedInteger('id_empresa')->nullable();
        //     $table->unsignedInteger('id_tipo_persona')->nullable();
        //     $table->unsignedInteger('id_tipo_documento')->nullable();
        //     $table->string('identificacion')->nullable();
        //     $table->string('nombres_proveedor')->nullable();
        //     $table->string('apellidos_proveedor')->nullable();
        //     $table->string('telefono_proveedor')->nullable();
        //     $table->string('celular_proveedor')->nullable();
        //     $table->string('email_proveedor')->nullable();
        //     $table->unsignedInteger('id_genero')->nullable();
        //     $table->string('direccion_proveedor')->nullable();
        //     $table->unsignedInteger('id_estado')->nullable();
        //     $table->string('nit_proveedor')->nullable();
        //     $table->string('proveedor_juridico')->nullable();
        //     $table->string('telefono_juridico')->nullable();

        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('id_empresa')->references('id_empresa')->on('empresas');
        //     $table->foreign('id_tipo_persona')->references('id_tipo_persona')->on('tipo_persona');
        //     $table->foreign('id_tipo_documento')->references('id_tipo_documento')->on('tipo_documento');
        //     $table->foreign('id_genero')->references('id_genero')->on('generos');
        //     $table->foreign('id_estado')->references('id_estado')->on('estados');
        // });

        if (!Schema::hasTable('proveedores')) {
            Schema::create('proveedores', function (Blueprint $table) {
                $table->increments('id_proveedor');
                $table->unsignedInteger('id_empresa')->nullable();
                $table->unsignedInteger('id_tipo_persona')->nullable();
                $table->unsignedInteger('id_tipo_documento')->nullable();
                $table->string('identificacion')->nullable();
                $table->string('nombres_proveedor')->nullable();
                $table->string('apellidos_proveedor')->nullable();
                $table->string('telefono_proveedor')->nullable();
                $table->string('celular_proveedor')->nullable();
                $table->string('email_proveedor')->nullable();
                $table->unsignedInteger('id_genero')->nullable();
                $table->string('direccion_proveedor')->nullable();
                $table->unsignedInteger('id_estado')->nullable();
                $table->string('nit_proveedor')->nullable();
                $table->string('proveedor_juridico')->nullable();
                $table->string('telefono_juridico')->nullable();

                $table->timestamps();
                $table->softDeletes();

                if (Schema::hasTable('empresas')) {
                    $table->foreign('id_empresa')->references('id_empresa')->on('empresas');
                }
                if (Schema::hasTable('tipo_persona')) {
                    $table->foreign('id_tipo_persona')->references('id_tipo_persona')->on('tipo_persona');
                }
                if (Schema::hasTable('tipo_documento')) {
                    $table->foreign('id_tipo_documento')->references('id_tipo_documento')->on('tipo_documento');
                }
                if (Schema::hasTable('generos')) {
                    $table->foreign('id_genero')->references('id_genero')->on('generos');
                }
                if (Schema::hasTable('estados')) {
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
        Schema::dropIfExists('proveedores');
    }
};
