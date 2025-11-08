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
        if (!Schema::hasTable('porcentajes_comision'))
        {
            Schema::create('porcentajes_comision', function (Blueprint $table) {
                $table->increments('id_porcentaje_comision');
                $table->string('porcentaje_comision')->nullable();
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
        if (Schema::hasTable('porcentajes_comision'))
        {
            Schema::dropIfExists('porcentajes_comision');
        }
    }
};
