<?php namespace Burgernod\Projects\Components;

use Cms\Classes\ComponentBase;
use Burgernod\Projects\Models\Service;
use Cms\Classes\PageNotFoundException;

class ServiceDetail extends ComponentBase
{
    public $service;

    public function componentDetails()
    {
        return [
            'name' => 'Service Detail',
            'description' => 'Displays service details by slug'
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
        $this->service = $this->page['service'] = $this->loadService();
    }

    protected function loadService()
    {
        $slug = $this->property('slug');
        $locale = app()->getLocale();

        $record = Service::query()
            ->with(['thumb', 'image']) 
            ->where('slug', $slug)
            ->where('locale', $locale)
            ->first();

        if (!$record) {
            throw new PageNotFoundException('Service not found');
        }

        return $record;
    }
}
