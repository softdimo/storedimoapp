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
        if ( !Schema::hasTable('tipo_documento') ) { 
            Schema::create('tipo_documento', function (Blueprint $table) {
                $table->increments('id_tipo_documento');
                $table->string('tipo_documento')->nullable();
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
        if (Schema::hasTable('tipo_documento') ) {
            Schema::dropIfExists('tipo_documento');
        }
    }
};
