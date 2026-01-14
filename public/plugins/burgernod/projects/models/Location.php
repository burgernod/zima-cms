<?php namespace Burgernod\Projects\Models;

use Model;

class Location extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    public $table = 'burgernod_projects_locations';

    public $rules = [];

    // Картинка A (thumbnail для списка) и картинка B (для детальной страницы)
    public $attachOne = [
        'thumb' => ['System\Models\File'],
        'image' => ['System\Models\File']
    ];

    protected $fillable = [
        'name',
        'address',
        'lat',
        'lng',
        'locale',
        'is_favorite',
        'slug',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
    ];
}
