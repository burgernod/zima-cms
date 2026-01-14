<?php namespace Burgernod\Projects\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateBurgernodProjectsProjects extends Migration
{
    public function up()
    {
        Schema::table('burgernod_projects_projects', function($table)
        {
            $table->decimal('lat', 10, 0)->nullable();
            $table->decimal('lng', 10, 0)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('burgernod_projects_projects', function($table)
        {
            $table->dropColumn('lat');
            $table->dropColumn('lng');
        });
    }
}
