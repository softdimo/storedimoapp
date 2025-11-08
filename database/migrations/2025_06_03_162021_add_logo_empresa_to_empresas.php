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
        //     $table->longText('logo_empresa')->nullable()->after('db_password');
        // });

        if (Schema::hasTable('empresas') && !Schema::hasColumn('empresas', 'logo_empresa')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->longText('logo_empresa')->nullable()->after('db_password');
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
        // Schema::table('empresas', function (Blueprint $table) {
        //     $table->dropColumn('logo_empresa');
        // });

        if (Schema::hasTable('empresas') && Schema::hasColumn('empresas', 'logo_empresa')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->dropColumn('logo_empresa');
            });
        }
    }
};
