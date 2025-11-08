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
        if (Schema::hasTable('usuarios')) {
            Schema::table('usuarios', function (Blueprint $table) {
                if (!Schema::hasColumn('usuarios', 'id_tipo_documento')) {
                    $table->unsignedInteger('id_tipo_documento')->nullable()->after('usuario');

                    if (Schema::hasTable('tipo_documento')) {
                        $table->foreign('id_tipo_documento')
                              ->references('id_tipo_documento')
                              ->on('tipo_documento');
                    }
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
        if (Schema::hasTable('usuarios')) {
            Schema::table('usuarios', function (Blueprint $table) {
                if (Schema::hasColumn('usuarios', 'id_tipo_documento')) {
                    $table->dropForeign(['id_tipo_documento']);
                    $table->dropColumn('id_tipo_documento');
                }
            });
        }
        
    }
};
