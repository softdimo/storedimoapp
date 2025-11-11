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
        if (Schema::hasTable('proveedores') && Schema::hasColumn('proveedores', 'id_tipo_documento')) {
            Schema::table('proveedores', function (Blueprint $table) {
                $table->dropForeign(['id_tipo_documento']);
            });
        }

        if (Schema::hasTable('proveedores') && Schema::hasColumn('proveedores', 'id_estado')) {
            Schema::table('proveedores', function (Blueprint $table) {
                $table->dropForeign(['id_estado']);
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
        if (Schema::hasTable('proveedores') && Schema::hasColumn('proveedores', 'id_tipo_documento')) {
            Schema::table('proveedores', function (Blueprint $table) {
                $table->foreign('id_tipo_documento')->references('id_tipo_documento')->on('tipo_documento');
            });
        }

        if (Schema::hasTable('proveedores') && Schema::hasColumn('proveedores', 'id_estado')) {
            Schema::table('proveedores', function (Blueprint $table) {
                $table->foreign('id_estado')->references('id_estado')->on('estados');
            });
        }
    }
};
