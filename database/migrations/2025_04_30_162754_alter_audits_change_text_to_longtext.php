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
        //     $table->longText('old_values')->change();
        //     $table->longText('new_values')->change();
        // });

        if (Schema::hasTable('audits')) {
            Schema::table('audits', function (Blueprint $table) {
                if (Schema::hasColumn('audits', 'old_values')) {
                    $table->longText('old_values')->change();
                }
                if (Schema::hasColumn('audits', 'new_values')) {
                    $table->longText('new_values')->change();
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
        // Schema::table('audits', function (Blueprint $table) {
        //     $table->text('old_values')->change();
        //     $table->text('new_values')->change();
        // });

        if (Schema::hasTable('audits')) {
            Schema::table('audits', function (Blueprint $table) {
                if (Schema::hasColumn('audits', 'old_values')) {
                    $table->text('old_values')->change();
                }
                if (Schema::hasColumn('audits', 'new_values')) {
                    $table->text('new_values')->change();
                }
            });
        }
    }
};
