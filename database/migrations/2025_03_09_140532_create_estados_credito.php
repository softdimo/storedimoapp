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
        if (!Schema::hasTable('estados_credito'))
        {
            Schema::create('estados_credito', function (Blueprint $table) {
                $table->increments('id_estado_credito');
                $table->string('estado_credito')->nullable();
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
        if (Schema::hasTable('estados_credito'))
        {
            Schema::dropIfExists('estados_credito');
        }
    }
};
