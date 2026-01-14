<?php namespace Burgernod\Projects\Components;

use Cms\Classes\ComponentBase;
use Burgernod\Projects\Models\Service;

class ServiceList extends ComponentBase
{
    public $services;

    public function componentDetails()
    {
        return [
            'name' => 'Service List',
            'description' => 'Displays a list of services'
        ];
    }

    public function defineProperties()
    {
        return [
            'detailPage' => [
                'title' => 'Detail page',
                'description' => 'Page for detail links',
                'type' => 'dropdown'
            ]
        ];
    }

    public function getDetailPageOptions()
    {
        return \Cms\Classes\Page::listPages();
    }

    public function onRun()
    {
        $locale = app()->getLocale();

        $query = Service::query()
            ->with('thumb') // главное!
            ->where('locale', $locale)
            ->orderBy('id', 'desc');

        $items = $query->get();

        $this->services = $items->map(function ($s) {
            return [
                'id'    => $s->id,
                'title' => $s->title,
                'slug'  => $s->slug,

                // используем attachOne thumb
                'thumb' => $s->thumb
                    ? $s->thumb->getThumb(400, 300, ['mode' => 'crop'])
                    : null,

                'url'   => $this->pageUrl(
                    $this->property('detailPage') ?: 'service',
                    ['slug' => $s->slug]
                ),
            ];
        })->toArray();
    }
}
