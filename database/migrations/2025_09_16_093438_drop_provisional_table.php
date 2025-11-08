<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('provisional')) {
            // Si la columna existe, intento eliminar la foreign key
            if (Schema::hasColumn('provisional', 'id_estado')) {
                Schema::table('provisional', function (Blueprint $table) {
                    try {
                        $table->dropForeign(['id_estado']);
                    } catch (\Exception $e) {
                        // La FK puede no existir en algunas BD, la ignoramos
                    }
                });
            }

            // Finalmente eliminamos la tabla
            Schema::dropIfExists('provisional');
        }
    }

    public function down()
    {
        if (!Schema::hasTable('provisional')) {
            Schema::create('provisional', function (Blueprint $table) {
                $table->increments('id_provisional');
                $table->string('descripcion');
                $table->unsignedInteger('id_estado');
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('id_estado')
                      ->references('id_estado')
                      ->on('estados');
            });
        }
    }
};
