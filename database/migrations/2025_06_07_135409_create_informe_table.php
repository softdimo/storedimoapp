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
        // Schema::create('informe', function (Blueprint $table) {
        //     $table->increments('informe_codigo');
        //     $table->string('informe_descripcion');
        //     $table->string('tabla_principal')->nullable();
        //     $table->text('where_principal')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        if (!Schema::hasTable('informe')) {
            Schema::create('informe', function (Blueprint $table) {
                $table->increments('informe_codigo');
                $table->string('informe_descripcion');
                $table->string('tabla_principal')->nullable();
                $table->text('where_principal')->nullable();
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
        // Schema::dropIfExists('informe');

        if (Schema::hasTable('informe')) {
            Schema::dropIfExists('informe');
        }
    }
};
