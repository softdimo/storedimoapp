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
        if (Schema::hasTable('venta_productos')) {
            if (!Schema::hasColumn('venta_productos', 'precio_unitario_venta')) {
                Schema::table('venta_productos', function (Blueprint $table) {
                    $table->string('precio_unitario_venta')->nullable()->after('cantidad');
                });
            }
    
            if (!Schema::hasColumn('venta_productos', 'ganancia_venta')) {
                 Schema::table('venta_productos', function (Blueprint $table) {
                    $table->string('ganancia_venta')->nullable()->after('subtotal');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('venta_productos')) {
            if (Schema::hasColumn('venta_productos', 'precio_unitario_venta')) {
               Schema::table('venta_productos', function (Blueprint $table) {
                   $table->dropColumn('precio_unitario_venta');
               });
           }
   
           if (Schema::hasColumn('venta_productos', 'ganancia_venta')) {
               Schema::table('venta_productos', function (Blueprint $table) {
                   $table->dropColumn('ganancia_venta');
               });
           }
       }
    }
};
