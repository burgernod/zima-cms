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
        Schema::table('burgernod_projects_projects', function($table)
        {
            $table->string('client')->nullable();
            $table->string('location')->nullable();
            $table->string('budget')->nullable();
            $table->integer('year')->nullable();
            $table->string('area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
    {
        Schema::table('burgernod_projects_projects', function($table)
        {
            // Проверяем наличие колонок перед удалением
            $columns = Schema::getColumnListing('burgernod_projects_projects');
            
            $columnsToRemove = [];
            if (in_array('client', $columns)) $columnsToRemove[] = 'client';
            if (in_array('location', $columns)) $columnsToRemove[] = 'location';
            if (in_array('budget', $columns)) $columnsToRemove[] = 'budget';
            if (in_array('year', $columns)) $columnsToRemove[] = 'year';
            if (in_array('area', $columns)) $columnsToRemove[] = 'area';
            
            if (count($columnsToRemove) > 0) {
                $table->dropColumn($columnsToRemove);
            }
        });
    }
};
