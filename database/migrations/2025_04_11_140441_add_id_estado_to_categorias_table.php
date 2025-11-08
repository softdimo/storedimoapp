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
        // Schema::table('categorias', function (Blueprint $table) {
        //     $table->unsignedInteger('id_estado')->nullable()->after('categoria');

        //     $table->foreign('id_estado')->references('id_estado')->on('estados');
        // });

        if (Schema::hasTable('categorias') && !Schema::hasColumn('categorias', 'id_estado')) {
            Schema::table('categorias', function (Blueprint $table) {
                $table->unsignedInteger('id_estado')->nullable()->after('categoria');

                if (Schema::hasTable('estados')) {
                    $table->foreign('id_estado')->references('id_estado')->on('estados');
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
        // Schema::table('categorias', function (Blueprint $table) {
        //     $table->dropColumn('id_estado');
        // });

        if (Schema::hasTable('categorias') && Schema::hasColumn('categorias', 'id_estado')) {
            Schema::table('categorias', function (Blueprint $table) {
                try {
                    $table->dropForeign(['id_estado']);
                } catch (\Exception $e) {
                    // ignorar si no existe la foreign key
                }

                $table->dropColumn('id_estado');
            });
        }
    }
};
