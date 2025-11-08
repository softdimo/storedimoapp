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
        //     $table->text('app_key')->change();
        //     $table->text('db_database')->change();
        //     $table->text('db_username')->change();
        //     $table->text('db_password')->change();
        // });

        Schema::table('empresas', function (Blueprint $table) {
            if (Schema::hasColumn('empresas', 'app_key')) {
                $table->text('app_key')->nullable()->change();
            }
            if (Schema::hasColumn('empresas', 'db_database')) {
                $table->text('db_database')->nullable()->change();
            }
            if (Schema::hasColumn('empresas', 'db_username')) {
                $table->text('db_username')->nullable()->change();
            }
            if (Schema::hasColumn('empresas', 'db_password')) {
                $table->text('db_password')->nullable()->change();
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
        //     $table->string('app_key')->change();
        //     $table->string('db_database')->change();
        //     $table->string('db_username')->change();
        //     $table->string('db_password')->change();
        // });

        Schema::table('empresas', function (Blueprint $table) {
            if (Schema::hasColumn('empresas', 'app_key')) {
                $table->string('app_key')->nullable()->change();
            }
            if (Schema::hasColumn('empresas', 'db_database')) {
                $table->string('db_database')->nullable()->change();
            }
            if (Schema::hasColumn('empresas', 'db_username')) {
                $table->string('db_username')->nullable()->change();
            }
            if (Schema::hasColumn('empresas', 'db_password')) {
                $table->string('db_password')->nullable()->change();
            }
        });
    }
};
