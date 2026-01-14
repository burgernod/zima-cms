<?php

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('burgernod_projects_projects', function (Blueprint $table) {
            $table->boolean('is_favorite')->default(false)->after('locale');
            $table->text('desc_list')->nullable()->after('is_favorite'); // JSON
        });
    }

    public function down()
    {
        Schema::table('burgernod_projects_projects', function (Blueprint $table) {
            if (Schema::hasColumn('burgernod_projects_projects', 'is_favorite')) {
                $table->dropColumn('is_favorite');
            }
            if (Schema::hasColumn('burgernod_projects_projects', 'desc_list')) {
                $table->dropColumn('desc_list');
            }
        });
    }
};