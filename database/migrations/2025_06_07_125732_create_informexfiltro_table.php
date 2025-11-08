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
        // Schema::create('informexfiltro', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('filtro_descripcion');
        //     $table->text('filtro_html');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        if (!Schema::hasTable('informexfiltro')) {
            Schema::create('informexfiltro', function (Blueprint $table) {
                $table->increments('id');
                $table->string('filtro_descripcion');
                $table->text('filtro_html');
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
        // Schema::dropIfExists('informexfiltro');

        if (Schema::hasTable('informexfiltro')) {
            Schema::dropIfExists('informexfiltro');
        }
    }
};
