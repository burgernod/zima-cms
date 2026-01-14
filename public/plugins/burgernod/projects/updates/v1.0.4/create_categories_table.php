<?php

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('burgernod_projects_categories', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('burgernod_projects_project_category', function ($table) {
            $table->integer('project_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['project_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('burgernod_projects_categories');
        Schema::dropIfExists('burgernod_projects_project_category');
    }
};
