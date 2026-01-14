<?php

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;

class CreateTwoFactorColumns extends Migration
{
    public function up()
    {
        Schema::table('backend_users', function (Blueprint $table) {
            $table->string('google2fa_secret')->nullable();
            $table->boolean('two_factor_enabled')->default(false);
        });
    }

    public function down()
    {
        Schema::table('backend_users', function (Blueprint $table) {
            if (Schema::hasColumn('backend_users', 'google2fa_secret')) {
                $table->dropColumn('google2fa_secret');
            }
            if (Schema::hasColumn('backend_users', 'two_factor_enabled')) {
                $table->dropColumn('two_factor_enabled');
            }
        });
    }
}