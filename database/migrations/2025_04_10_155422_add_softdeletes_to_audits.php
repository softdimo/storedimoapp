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
        // Schema::table('audits', function (Blueprint $table) {
        //     $table->softDeletes();
        // });

        if (Schema::hasTable('audits') && !Schema::hasColumn('audits', 'deleted_at')) {
            Schema::table('audits', function (Blueprint $table) {
                $table->softDeletes();
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
        // Schema::table('audits', function (Blueprint $table) {
        //     $table->dropSoftDeletes();
        // });

        if (Schema::hasTable('audits') && Schema::hasColumn('audits', 'deleted_at')) {
            Schema::table('audits', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
