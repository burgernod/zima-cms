<?php

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('burgernod_projects_projects', function (Blueprint $table) {
            $table->string('locale', 10)->default('en')->after('year')->index();
        });
    }

    public function down()
    {
        Schema::table('burgernod_projects_projects', function (Blueprint $table) {
            if (Schema::hasColumn('burgernod_projects_projects', 'locale')) {
                $table->dropColumn('locale');
            }
        });
    }
};