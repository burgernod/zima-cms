<?php namespace Burgernod\Projects\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateBurgernodProjectsCommunities extends Migration
{
    public function up()
    {
        Schema::create('burgernod_projects_communities', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->text('desc_list')->nullable();
            $table->string('slug');
            $table->string('locale')->default('en');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('burgernod_projects_communities');
    }
}
