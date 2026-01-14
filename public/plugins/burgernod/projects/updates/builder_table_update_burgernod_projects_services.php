<?php namespace Burgernod\Projects\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateBurgernodProjectsServices extends Migration
{
    public function up()
    {
        Schema::table('burgernod_projects_services', function($table)
        {
            $table->string('locale')->default('en')->change();
        });
    }
    
    public function down()
    {
        Schema::table('burgernod_projects_services', function($table)
        {
            $table->string('locale')->default(null)->change();
        });
    }
}
