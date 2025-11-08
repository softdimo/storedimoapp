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
        // Schema::create('bajas_detalle', function (Blueprint $table) {
        //     $table->increments('id_baja_detalle');
        //     $table->unsignedInteger('id_baja')->nullable();
        //     $table->unsignedInteger('id_tipo_baja')->nullable();
        //     $table->unsignedInteger('id_producto')->nullable();
        //     $table->string('cantidad')->nullable();

        //     $table->timestamps();
        //     $table->softDeletes();

        //     $table->foreign('id_baja')->references('id_baja')->on('bajas')->onDelete('cascade');
        //     $table->foreign('id_tipo_baja')->references('id_tipo_baja')->on('tipo_baja')->onDelete('cascade');
        //     $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
        // });

        // Crear tabla si no existe
        if (!Schema::hasTable('bajas_detalle')) {
            Schema::create('bajas_detalle', function (Blueprint $table) {
                $table->increments('id_baja_detalle');
                $table->unsignedInteger('id_baja')->nullable();
                $table->unsignedInteger('id_tipo_baja')->nullable();
                $table->unsignedInteger('id_producto')->nullable();
                $table->string('cantidad')->nullable();

                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Agregar FK id_baja → bajas.id_baja
        if (
            Schema::hasTable('bajas_detalle') &&
            Schema::hasColumn('bajas_detalle', 'id_baja') &&
            Schema::hasTable('bajas') &&
            Schema::hasColumn('bajas', 'id_baja')
        ) {
            Schema::table('bajas_detalle', function (Blueprint $table) {
                $table->foreign('id_baja')
                      ->references('id_baja')
                      ->on('bajas')
                      ->onDelete('cascade');
            });
        }

        // Agregar FK id_tipo_baja → tipo_baja.id_tipo_baja
        if (
            Schema::hasTable('bajas_detalle') &&
            Schema::hasColumn('bajas_detalle', 'id_tipo_baja') &&
            Schema::hasTable('tipo_baja') &&
            Schema::hasColumn('tipo_baja', 'id_tipo_baja')
        ) {
            Schema::table('bajas_detalle', function (Blueprint $table) {
                $table->foreign('id_tipo_baja')
                      ->references('id_tipo_baja')
                      ->on('tipo_baja')
                      ->onDelete('cascade');
            });
        }

        // Agregar FK id_producto → productos.id_producto
        if (
            Schema::hasTable('bajas_detalle') &&
            Schema::hasColumn('bajas_detalle', 'id_producto') &&
            Schema::hasTable('productos') &&
            Schema::hasColumn('productos', 'id_producto')
        ) {
            Schema::table('bajas_detalle', function (Blueprint $table) {
                $table->foreign('id_producto')
                      ->references('id_producto')
                      ->on('productos')
                      ->onDelete('cascade');
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
        // Schema::dropIfExists('bajas_detalle');

        if (Schema::hasTable('bajas_detalle')) {
            Schema::table('bajas_detalle', function (Blueprint $table) {
                if (Schema::hasColumn('bajas_detalle', 'id_baja')) {
                    $table->dropForeign(['id_baja']);
                }
                if (Schema::hasColumn('bajas_detalle', 'id_tipo_baja')) {
                    $table->dropForeign(['id_tipo_baja']);
                }
                if (Schema::hasColumn('bajas_detalle', 'id_producto')) {
                    $table->dropForeign(['id_producto']);
                }
            });

            Schema::dropIfExists('bajas_detalle');
        }
    }
};
