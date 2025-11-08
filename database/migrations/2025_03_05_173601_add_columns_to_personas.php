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
        if (Schema::hasTable('personas')) {
            Schema::table('personas', function (Blueprint $table) {
                if (!Schema::hasColumn('personas', 'nit_empresa')) {
                    $table->string('nit_empresa')->nullable()->after('id_estado');
                }

                if (!Schema::hasColumn('personas', 'nombre_empresa')) {
                    $table->string('nombre_empresa')->nullable()->after('nit_empresa');
                }

                if (!Schema::hasColumn('personas', 'telefono_empresa')) {
                    $table->string('telefono_empresa')->nullable()->after('nombre_empresa');
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
        if (Schema::hasTable('personas')) {
            Schema::table('personas', function (Blueprint $table) {
                foreach (['nit_empresa', 'nombre_empresa', 'telefono_empresa'] as $columna) {
                    if (Schema::hasColumn('personas', $columna)) {
                        $table->dropColumn($columna);
                    }
                }
            });
        }
    }
};
