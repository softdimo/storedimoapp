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
        // Schema::create('informe_inner_join', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('informe_codigo');
        //     $table->text('infxcampos');
        //     $table->text('inner_join');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        if (!Schema::hasTable('informe_inner_join')) {
            Schema::create('informe_inner_join', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('informe_codigo');
                $table->text('infxcampos');
                $table->text('inner_join');
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
        // Schema::dropIfExists('informe_inner_join');

        if (Schema::hasTable('informe_inner_join')) {
            Schema::dropIfExists('informe_inner_join');
        }
    }
};
