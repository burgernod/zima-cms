<?php namespace Burgernod\Projects\Components;

use Cms\Classes\ComponentBase;
use Burgernod\Projects\Models\Community;
use Cms\Classes\PageNotFoundException;

class CommunityDetail extends ComponentBase
{
    public $community;

    public function componentDetails()
    {
        return [
            'name' => 'Community Detail',
            'description' => 'Displays community details by slug'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Slug',
                'description' => 'Record slug',
                'default' => '{{ :slug }}',
                'type' => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $this->community = $this->page['community'] = $this->loadCommunity();
    }

    protected function loadCommunity()
    {
        $slug = $this->property('slug');
        $locale = app()->getLocale();

        $record = Community::query()
            ->with(['thumb', 'image'])   // ← исправлено
            ->where('slug', $slug)
            ->where('locale', $locale)
            ->first();

        if (!$record) {
            throw new PageNotFoundException('Community not found');
        }

        return $record;
    }
}
