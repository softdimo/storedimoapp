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
        if (!Schema::hasTable('tipos_pago'))
        {
            Schema::create('tipos_pago', function (Blueprint $table) {
                $table->increments('id_tipo_pago');
                $table->string('tipo_pago')->nullable();
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
        if (Schema::hasTable('tipos_pago'))
        {
            Schema::dropIfExists('tipos_pago');
        }
    }
};
