<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources',function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('resource_categories');
            $table->char('title',255);
            $table->text('content');
            $table->text('action');
            $table->char('file_key',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
