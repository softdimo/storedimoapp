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
        //     $table->text('db_host')->nullable()->after('id_tipo_bd'); // db host
        // });

        if (Schema::hasTable('empresas') && !Schema::hasColumn('empresas', 'db_host')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->text('db_host')->nullable()->after('id_tipo_bd'); // db host
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
        //     $table->dropColumn('db_host'); // db host
        // });

        if (Schema::hasTable('empresas') && Schema::hasColumn('empresas', 'db_host')) {
            Schema::table('empresas', function (Blueprint $table) {
                $table->dropColumn('db_host'); // db host
            });
        }
    }
};
