<?php namespace Burgernod\Projects\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateBurgernodProjectsServices extends Migration
{
    public function up()
    {
        Schema::create('burgernod_projects_services', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('locale');
            $table->text('description');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('burgernod_projects_services');
    }
}
