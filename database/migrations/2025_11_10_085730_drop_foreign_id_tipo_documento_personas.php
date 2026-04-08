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
        if (Schema::hasTable('personas') && Schema::hasColumn('personas', 'id_tipo_documento')) {
            Schema::table('personas', function (Blueprint $table) {
                try
                {
                    $table->dropForeign(['id_tipo_documento']);

                } catch (\Exception $e) {
                    // La FK puede no existir en algunas BD, la ignoramos
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
        if (Schema::hasTable('personas') && Schema::hasColumn('personas', 'id_tipo_documento')) {
            Schema::table('personas', function (Blueprint $table) {
                $table->foreign('id_tipo_documento')->references('id_tipo_documento')->on('tipo_documento');
            });
        }
    }
};
