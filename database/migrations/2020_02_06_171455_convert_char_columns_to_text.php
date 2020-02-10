<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConvertCharColumnsToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resources',function(Blueprint $table) {
            $table->text('title')->change();
            $table->text('file_key')->nullable()->change();
        });

        Schema::table('resource_categories',function(Blueprint $table) {
            $table->text('title')->change();
            $table->text('icon')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resources',function(Blueprint $table) {
            $table->char('title',255)->change();
            $table->char('file_key',255)->nullable()->change();
        });

        Schema::table('resource_categories',function(Blueprint $table) {
            $table->char('title',255);
            $table->char('icon',50);
        });
    }
}
