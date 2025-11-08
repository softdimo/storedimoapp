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
        if (!Schema::hasTable('test2'))
        {
            Schema::create('test2', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('descripcion')->nullable();
                $table->boolean('estado')->default(true);
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
        if (Schema::hasTable('test2'))
        {
            Schema::dropIfExists('test2');
        }
    }
};
