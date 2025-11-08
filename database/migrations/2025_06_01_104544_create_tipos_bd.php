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
        // Schema::create('tipos_bd', function (Blueprint $table) {
        //     $table->increments('id_tipo_bd');
        //     $table->string('tipo_bd')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        if (!Schema::hasTable('tipos_bd')) {
            Schema::create('tipos_bd', function (Blueprint $table) {
                $table->increments('id_tipo_bd');
                $table->string('tipo_bd')->nullable();
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
        Schema::dropIfExists('tipos_bd');
    }
};
