<?php

use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // SQLite не умеет менять таблицы — пересоздаем корректно
        Schema::create('burgernod_projects_locations_tmp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');

            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();

            // НОВЫЕ СТОЛБЦЫ
            $table->string('locale', 10)->default('en')->index();
            $table->boolean('is_favorite')->default(false);
            $table->string('slug')->nullable()->unique();

            $table->timestamps();
        });

        // Перенос данных из старой таблицы
        if (Schema::hasTable('burgernod_projects_locations')) {
            $rows = DB::table('burgernod_projects_locations')->get();

            foreach ($rows as $row) {
                DB::table('burgernod_projects_locations_tmp')->insert([
                    'id'         => $row->id,
                    'name'       => $row->name,
                    'address'    => $row->address,
                    'lat'        => $row->lat,
                    'lng'        => $row->lng,
                    'locale'     => 'en',
                    'is_favorite'=> false,
                    'slug'       => Str::slug($row->name),
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ]);
            }
        }

        Schema::dropIfExists('burgernod_projects_locations');
        Schema::rename('burgernod_projects_locations_tmp', 'burgernod_projects_locations');
    }

    public function down()
    {
        // Откат невозможен — таблица потеряет данные
    }
};
