<?php namespace Burgernod\Projects\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateBurgernodProjectsServices2 extends Migration
{
    public function up()
    {
        Schema::table('burgernod_projects_services', function($table)
        {
            $table->text('desc_list')->nullable();
            $table->dropColumn('description');
        });
    }
    
    public function down()
    {
        Schema::table('burgernod_projects_services', function($table)
        {
            $table->dropColumn('desc_list');
            $table->text('description');
        });
    }
}
