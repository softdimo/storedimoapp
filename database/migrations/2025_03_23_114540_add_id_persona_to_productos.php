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
        if (Schema::hasTable('productos'))
        {
            Schema::table('productos', function (Blueprint $table) {
                $table->unsignedInteger('id_persona')->nullable()->after('id_empresa');

                if (Schema::hasTable('personas'))
                {
                    $table->foreign('id_persona')->references('id_persona')->on('personas');
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
        if (Schema::hasTable('productos'))
        {
            Schema::table('productos', function (Blueprint $table) {
                $table->dropColumn('id_persona');
            });
        }
    }
};
