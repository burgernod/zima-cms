<?php

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('burgernod_projects_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');          // Название базы
            $table->string('address');       // Адрес
            $table->decimal('lat', 10, 7)->nullable(); // широта
            $table->decimal('lng', 10, 7)->nullable(); // долгота
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('burgernod_projects_locations');
    }
};
