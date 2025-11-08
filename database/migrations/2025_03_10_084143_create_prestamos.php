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
        if (!Schema::hasTable('prestamos'))
        {
            Schema::create('prestamos', function (Blueprint $table) {
                $table->increments('id_prestamo');
                $table->unsignedInteger('id_estado_prestamo')->nullable();
                $table->unsignedInteger('id_usuario')->nullable();
                $table->string('valor_prestamo')->nullable();
                $table->date('fecha_prestamo')->nullable();
                $table->date('fecha_limite')->nullable();
                $table->string('descripcion')->nullable();
                $table->timestamps();
                $table->softDeletes();

                if (Schema::hasTable('estados_prestamo'))
                {
                    $table->foreign('id_estado_prestamo')->references('id_estado_prestamo')->on('estados_prestamo');
                }

                if (Schema::hasTable('usuarios'))
                {
                    $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
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
        if (Schema::hasTable('prestamos'))
        {
            Schema::dropIfExists('prestamos');
        }
    }
};
