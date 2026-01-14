<?php namespace Burgernod\Projects\Components;

use Cms\Classes\ComponentBase;
use Burgernod\Projects\Models\Community;
use Lang;

class CommunityList extends ComponentBase
{
    public $communities;

    public function componentDetails()
    {
        return [
            'name' => 'Community List',
            'description' => 'Displays a list of community projects'
        ];
    }

    public function defineProperties()
    {
        return [
            'perPage' => [
                'title' => 'Per page',
                'description' => 'Items per page',
                'default' => 12,
                'type' => 'string'
            ],
            'pageNumber' => [
                'title' => 'Page number',
                'description' => 'Current page number',
                'default' => '{{ :page }}',
                'type' => 'string'
            ],
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

        $query = Community::query()
            ->with('thumb') // главное!
            ->where('locale', $locale)
            ->orderBy('id', 'desc');

        $items = $query->get();

        $this->communities = $items->map(function ($c) {
            return [
                'id'    => $c->id,
                'title' => $c->title,
                'slug'  => $c->slug,

                // attachOne thumb
                'thumb' => $c->thumb
                    ? $c->thumb->getThumb(400, 300, ['mode' => 'crop'])
                    : null,

                'url'   => $this->pageUrl(
                    $this->property('detailPage') ?: 'community',
                    ['slug' => $c->slug]
                ),
            ];
        })->toArray();
    }
}