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
        if (Schema::hasTable('prestamos'))
        {
            Schema::table('prestamos', function (Blueprint $table) {
                $table->unsignedInteger('id_empresa')->nullable()->after('id_prestamo');

                if (Schema::hasTable('prestamos'))
                {
                    $table->foreign('id_empresa')->references('id_empresa')->on('empresas');
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
        if (Schema::hasTable('prestamos'))
        {
            Schema::table('prestamos', function (Blueprint $table) {
                $table->dropColumn('id_empresa');
            });
        }
    }
};
