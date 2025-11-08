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
        if ( !Schema::hasTable('tipo_persona') ) {
            Schema::create('tipo_persona', function (Blueprint $table) {
                $table->increments('id_tipo_persona');
                $table->string('tipo_persona')->nullable();
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
        if( Schema::hasTable('tipo_persona') ) {
            Schema::dropIfExists('tipo_persona');
        }
    }
};
