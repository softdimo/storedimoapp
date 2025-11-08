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
        if (!Schema::hasTable('compra_productos'))
        {
            Schema::create('compra_productos', function (Blueprint $table) {
                $table->increments('id_compra_producto');
                $table->unsignedInteger('id_compra')->nullable();
                $table->unsignedInteger('id_producto')->nullable();
                $table->string('cantidad')->nullable();
                $table->string('precio_unitario_compra')->nullable();
                $table->string('subtotal')->nullable();
                $table->timestamps();
                $table->softDeletes();

                if (Schema::hasTable('compras'))
                {
                    $table->foreign('id_compra')->references('id_compra')->on('compras')->onDelete('cascade');
                }

                if (Schema::hasTable('productos'))
                {
                    $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
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
        if (Schema::hasTable('compra_productos'))
        {
            Schema::dropIfExists('compra_productos');
        }
    }
};
