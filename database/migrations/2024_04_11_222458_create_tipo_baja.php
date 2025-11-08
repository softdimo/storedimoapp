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
        if ( !Schema::hasTable('tipo_baja') ) {
            Schema::create('tipo_baja', function (Blueprint $table) {
                $table->increments('id_tipo_baja');
                $table->string('tipo_baja')->nullable();
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
        if (Schema::hasTable('tipo_baja') ) {
            Schema::dropIfExists('tipo_baja');
        }
    }
};
