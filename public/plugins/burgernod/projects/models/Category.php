<?php

namespace Burgernod\Projects\Models;

use Winter\Storm\Database\Model;
use Winter\Storm\Database\Traits\Sluggable;
use Winter\Storm\Database\Traits\Validation;

/**
 * Category Model
 */
class Category extends Model
{
    use Sluggable;
    use Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'burgernod_projects_categories';

    /**
     * @var array Slugs to auto-generate
     */
    protected $slugs = ['slug' => 'name'];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'slug'];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

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
        'projects' => [
            'Burgernod\Projects\Models\Project',
            'table' => 'burgernod_projects_project_category',
            'key' => 'category_id',
            'otherKey' => 'project_id'
        ]
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}