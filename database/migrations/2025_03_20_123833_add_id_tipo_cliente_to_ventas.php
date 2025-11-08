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
        if (Schema::hasTable('ventas'))
        {
            Schema::table('ventas', function (Blueprint $table) {
                $table->unsignedInteger('id_tipo_cliente')->nullable()->after('id_empresa');

                if (Schema::hasTable('tipo_persona'))
                {
                    $table->foreign('id_tipo_cliente')->references('id_tipo_persona')->on('tipo_persona');
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
        if (Schema::hasTable('ventas'))
        {
            Schema::table('ventas', function (Blueprint $table) {
                $table->dropColumn('id_tipo_cliente');
            });
        }
    }
};
