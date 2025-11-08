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
        if (!Schema::hasTable('pago_empleados'))
        {
            Schema::create('pago_empleados', function (Blueprint $table) {
                $table->increments('id_pago_empleado');
                $table->dateTime('fecha_pago')->nullable();
                $table->unsignedInteger('id_usuario')->nullable();
                $table->string('valor_ventas')->nullable();
                $table->string('valor_comision')->nullable();
                $table->string('cantidad_dias')->nullable();
                $table->string('valor_dia')->nullable();
                $table->string('valor_prima')->nullable();
                $table->string('valor_vacaciones')->nullable();
                $table->string('valor_cesantias')->nullable();
                $table->unsignedInteger('id_estado')->nullable();
                $table->timestamps();
                $table->softDeletes();

                if (Schema::hasTable('usuarios'))
                {
                    $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
                }

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
        if (Schema::hasTable('pago_empleados'))
        {
            Schema::dropIfExists('pago_empleados');
        }
    }
};
