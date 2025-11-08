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
        if (Schema::hasTable('compras') && Schema::hasColumn('compras', 'fecha_compra')) {
            Schema::table('compras', function (Blueprint $table) {
                $table->dateTime('fecha_compra')->nullable()->change();
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
        if (Schema::hasTable('compras') && Schema::hasColumn('compras', 'fecha_compra')) {
            Schema::table('compras', function (Blueprint $table) {
                $table->date('fecha_compra')->nullable()->change();
            });
        }
    }
};
