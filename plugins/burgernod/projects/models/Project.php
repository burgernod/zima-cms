<?php

namespace Burgernod\Projects\Models;

use Winter\Storm\Database\Model;
use Winter\Storm\Database\Traits\Sluggable;
use Winter\Storm\Database\Traits\Validation;

/**
 * Project Model
 */
class Project extends Model
{
    use Sluggable;
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'burgernod_projects_projects';

    /**
     * @var array Slugs to auto-generate
     */
    protected $slugs = ['slug' => 'title'];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'title' => 'required|max:255',
        'slug' => 'required',
        'locale' => 'required',
        // client, location, budget - необязательные, без правил
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'client',
        'location',
        'budget',
        'year',
        'area',
        'locale',
        'desc_list'
    ];

    public function getLocaleOptions()
    {
        return [
            'en'    => 'English',
            'ru'    => 'Русский',
            'kk'    => 'Қазақша',
            'zh-CN'   => '中文 (中国)',
        ];
    }

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [
        'is_favorite' => 'boolean',
    ];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'categories',
        'desc_list'
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'categories' => [
            'Burgernod\Projects\Models\Category',
            'table' => 'burgernod_projects_project_category',
            'key' => 'project_id',
            'otherKey' => 'category_id'
        ]
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'thumb' => ['System\Models\File'],
    ];
    public $attachMany = [
        'photos' => ['System\Models\File']
    ];
}