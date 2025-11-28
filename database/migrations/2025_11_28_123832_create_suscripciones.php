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
        if (!Schema::hasTable('suscripciones'))
        {
            Schema::create('suscripciones', function (Blueprint $table) {
                $table->increments('id_suscripcion');
                $table->unsignedInteger('id_empresa_suscrita')->nullable();
                $table->unsignedInteger('id_plan_suscrito')->nullable();
                $table->string('dias_trial')->nullable();
                $table->unsignedInteger('id_tipo_pago_suscripcion')->nullable();
                $table->string('valor_suscripcion')->nullable();
                $table->date('fecha_inicial')->nullable();
                $table->date('fecha_final')->nullable();
                $table->unsignedInteger('id_estado_suscripcion')->nullable();
                $table->date('fecha_cancelacion')->nullable();
                $table->boolean('renovacion_automatica')->nullable();
                $table->string('observaciones_suscripcion')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('id_empresa_suscrita')->references('id_empresa')->on('empresas');
                $table->foreign('id_plan_suscrito')->references('id_plan')->on('planes');
                $table->foreign('id_tipo_pago_suscripcion')->references('id_tipo_pago')->on('tipos_pago');
                $table->foreign('id_estado_suscripcion')->references('id_estado')->on('estados');
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
        if (Schema::hasTable('suscripciones'))
        {
            Schema::dropIfExists('suscripciones');
        }
    }
};
