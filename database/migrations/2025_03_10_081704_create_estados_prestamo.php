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
        if (!Schema::hasTable('estados_prestamo'))
        {
            Schema::create('estados_prestamo', function (Blueprint $table) {
                $table->increments('id_estado_prestamo');
                $table->string('estado_prestamo')->nullable();
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
        if (Schema::hasTable('estados_prestamo'))
        {
            Schema::dropIfExists('estados_prestamo');
        }
    }
};
