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
        if (!Schema::hasTable('periodos_pago'))
        {
            Schema::create('periodos_pago', function (Blueprint $table) {
                $table->increments('id_periodo_pago');
                $table->string('periodo_pago')->nullable();
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
        if (Schema::hasTable('periodos_pago'))
        {
            Schema::dropIfExists('periodos_pago');
        }
    }
};
