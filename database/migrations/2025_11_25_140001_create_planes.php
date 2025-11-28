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
        if (!Schema::hasTable('planes'))
        {
            Schema::create('planes', function (Blueprint $table)
            {
                $table->increments('id_plan');
                $table->string('nombre_plan')->nullable();
                $table->string('valor_mensual')->nullable();
                $table->string('valor_trimestral')->nullable();
                $table->string('valor_semestral')->nullable();
                $table->string('valor_anual')->nullable();
                $table->string('descripcion_plan')->nullable();
                $table->unsignedInteger('id_estado_plan')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('id_estado_plan')->references('id_estado')->on('estados');
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
        if (Schema::hasTable('planes'))
        {
            Schema::dropIfExists('planes');
        }
    }
};
