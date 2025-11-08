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
        // Schema::table('empresas', function (Blueprint $table) {
        //     $table->string('app_key')->nullable()->after('direccion_empresa'); // app key
        //     $table->string('app_url')->nullable()->after('app_key'); // app url
        //     $table->unsignedInteger('id_tipo_bd')->nullable()->after('app_url'); // db connection
        //     $table->string('db_database')->nullable()->after('id_tipo_bd'); // db database
        //     $table->string('db_username')->nullable()->after('db_database'); // db username
        //     $table->string('db_password')->nullable()->after('db_username'); // db password

        //     $table->foreign('id_tipo_bd')->references('id_tipo_bd')->on('tipos_bd');
        // });

        Schema::table('empresas', function (Blueprint $table) {
            if (!Schema::hasColumn('empresas', 'app_key')) {
                $table->string('app_key')->nullable()->after('direccion_empresa'); // app key
            }
            if (!Schema::hasColumn('empresas', 'app_url')) {
                $table->string('app_url')->nullable()->after('app_key'); // app url
            }
            if (!Schema::hasColumn('empresas', 'id_tipo_bd')) {
                $table->unsignedInteger('id_tipo_bd')->nullable()->after('app_url'); // db connection
            }
            if (!Schema::hasColumn('empresas', 'db_database')) {
                $table->string('db_database')->nullable()->after('id_tipo_bd'); // db database
            }
            if (!Schema::hasColumn('empresas', 'db_username')) {
                $table->string('db_username')->nullable()->after('db_database'); // db username
            }
            if (!Schema::hasColumn('empresas', 'db_password')) {
                $table->string('db_password')->nullable()->after('db_username'); // db password
            }

            if (Schema::hasTable('tipos_bd') && Schema::hasColumn('empresas', 'id_tipo_bd')) {
                $table->foreign('id_tipo_bd')->references('id_tipo_bd')->on('tipos_bd');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('empresas', function (Blueprint $table) {
        //     $table->dropColumn('app_key'); // app key
        //     $table->dropColumn('app_url'); // app url
        //     $table->dropColumn('id_tipo_bd'); // db connection
        //     $table->dropColumn('db_database'); // db database
        //     $table->dropColumn('db_username'); // db username
        //     $table->dropColumn('db_password'); // db password
        // });

        Schema::table('empresas', function (Blueprint $table) {
            if (Schema::hasColumn('empresas', 'id_tipo_bd')) {
                $table->dropForeign(['id_tipo_bd']); // eliminar FK antes
            }

            foreach (['app_key', 'app_url', 'id_tipo_bd', 'db_database', 'db_username', 'db_password'] as $col) {
                if (Schema::hasColumn('empresas', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
