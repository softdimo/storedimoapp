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
        if (!Schema::connection('mysql')->hasTable('tipos_metrica')) {
            Schema::connection('mysql')->create('tipos_metrica', function (Blueprint $table) {
                $table->increments('id_tipo_metrica');
                $table->string('tipo_metrica')->nullable();
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
        if (Schema::connection('mysql')->hasTable('tipos_metrica')) {
            Schema::connection('mysql')->dropIfExists('tipos_metrica');
        }
    }
};
