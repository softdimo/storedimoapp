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
        // if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'id_estado')) {
        //     Schema::table('usuarios', function (Blueprint $table) {
        //         try
        //         {
        //             $table->dropForeign(['id_estado']);
                    
        //         } catch (\Exception $e) {
        //             // No existe la FK, continuar sin romper
        //         }

        //          try 
        //          {
        //             $table->dropIndex('usuarios_id_estado_foreign'); // este sí existe

        //         } catch (\Throwable $e) {}

        //     });
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'id_estado')) {
        //     Schema::table('usuarios', function (Blueprint $table) {
        //         $table->foreign('id_estado')->references('id_estado')->on('estados');
        //     });
        // }
    }
};
