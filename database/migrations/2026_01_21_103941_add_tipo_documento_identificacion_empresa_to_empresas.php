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
        if (Schema::hasTable('empresas')) {
            if (!Schema::hasColumn('empresas', 'id_tipo_documento')) {
                Schema::table('empresas', function (Blueprint $table) {
                    $table->unsignedInteger('id_tipo_documento')->nullable()->after('id_empresa');
                });

                Schema::table('empresas', function (Blueprint $table) {
                    // 2. Crear la foránea por separado
                    $table->foreign('id_tipo_documento')->references('id_tipo_documento')->on('tipo_documento');
                });
            }
    
            if (!Schema::hasColumn('empresas', 'ident_empresa_natural')) {
                Schema::table('empresas', function (Blueprint $table)
                {
                    $table->string('ident_empresa_natural')->nullable()->after('nit_empresa');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('empresas')) {
            if (Schema::hasColumn('empresas', 'id_tipo_documento'))
            {
                Schema::table('empresas', function (Blueprint $table) {
                    $table->dropForeign(['id_tipo_documento']);
                    $table->dropColumn('id_tipo_documento');
                });
            }

            if (Schema::hasColumn('empresas', 'ident_empresa_natural'))
            {
                Schema::table('empresas', function (Blueprint $table){
                    $table->dropColumn('ident_empresa_natural');
                });
            }
        }
    }
};
