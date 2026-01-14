<?php namespace Burgernod\Projects\Components;

use Cms\Classes\ComponentBase;
use Burgernod\Projects\Models\Location;

class LocationDetail extends ComponentBase
{
    public $location;

    public function componentDetails()
    {
        return [
            'name'        => 'Location Detail',
            'description' => 'Display a single base (location).'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'   => 'Slug',
                'default' => '{{ :slug }}',
                'type'    => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $slug   = $this->property('slug');
        $locale = app()->getLocale();

        $this->location = Location::where('slug', $slug)
            ->where('locale', $locale)
            ->firstOrFail();

        $this->page['location'] = $this->location;
    }
}
