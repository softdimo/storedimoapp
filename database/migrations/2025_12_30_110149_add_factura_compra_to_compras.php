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
        if (Schema::hasTable('compras') && !Schema::hasColumn('compras', 'factura_compra')) {
            Schema::table('compras', function (Blueprint $table) {
                $table->string('factura_compra')->nullable()->after('id_empresa');
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
        if (Schema::hasTable('compras') && Schema::hasColumn('compras', 'factura_compra')) {
            Schema::table('compras', function (Blueprint $table) {
                $table->dropColumn('factura_compra');
            });
        }
    }
};
