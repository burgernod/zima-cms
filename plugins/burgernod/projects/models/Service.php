<?php namespace Burgernod\Projects\Models;

use Model;

class Service extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\Sluggable;

    public $table = 'burgernod_projects_services';
    public $timestamps = false;

    public $rules = [
        'title' => 'required'
    ];

    /**
     * Автогенерация slug
     */
    protected $slugs = ['slug' => 'title'];

    /**
     * JSON поля
     */
    protected $jsonable = ['desc_list'];

    /**
     * Массовое заполнение
     */
    protected $fillable = ['title', 'slug', 'locale', 'desc_list'];

    /**
     * Фотографии
     */
    public $attachOne = [
        'thumb' => ['System\Models\File'],
        'image' => ['System\Models\File']
    ];

    /**
     * Локали
     */
    public function getLocaleOptions()
    {
        return [
            'en'    => 'English',
            'ru'    => 'Русский',
            'kk'    => 'Қазақша',
            'zh-CN' => '中文 (中国)',
        ];
    }

}
