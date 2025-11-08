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
        // Schema::create('menu', function (Blueprint $table)
        // {
        //     $table->increments('id_menu')->unsigned();
        //     $table->string('nombre');
        //     $table->string('ruta');
        //     $table->string('icono')->nullable();
        //     $table->boolean('padre')->nullable();
        //     $table->boolean('hijo')->nullable();
        //     $table->boolean('abuelo')->nullable();
        //     $table->integer('menu_id')->unsigned();
        //     $table->biginteger('permission_id')->unsigned();
        //     $table->integer('estado_id')->unsigned();
        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('permission_id')->references('id')->on('permissions');
        //     $table->foreign('estado_id')->references('id_estado')->on('estados');
        // });

        if (!Schema::hasTable('menu')) {
            Schema::create('menu', function (Blueprint $table) {
                $table->increments('id_menu');
                $table->string('nombre');
                $table->string('ruta');
                $table->string('icono')->nullable();

                $table->boolean('padre')->nullable();
                $table->boolean('hijo')->nullable();
                $table->boolean('abuelo')->nullable();

                $table->unsignedInteger('menu_id')->nullable(); // relación consigo mismo
                $table->unsignedBigInteger('permission_id')->nullable();
                $table->unsignedInteger('estado_id')->nullable();

                $table->timestamps();
                $table->softDeletes();

                // Relaciones si las tablas existen
                if (Schema::hasTable('permissions')) {
                    $table->foreign('permission_id')->references('id')->on('permissions');
                }

                if (Schema::hasTable('estados')) {
                    $table->foreign('estado_id')->references('id_estado')->on('estados');
                }
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
        Schema::dropIfExists('menu');
    }
};
