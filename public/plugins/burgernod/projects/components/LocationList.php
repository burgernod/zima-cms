<?php namespace Burgernod\Projects\Components;

use Cms\Classes\ComponentBase;
use Burgernod\Projects\Models\Location;

class LocationList extends ComponentBase
{
    public $locations;

    public function componentDetails()
    {
        return [
            'name'        => 'Location List',
            'description' => 'Display a list of bases (locations).'
        ];
    }

    public function defineProperties()
    {
        return [
            'limit' => [
                'title'       => 'Limit',
                'description' => 'Number of locations to display (0 = all)',
                'type'        => 'string',
                'default'     => 0,
            ],
            'favoritesOnly' => [
                'title'       => 'Show only favorite locations',
                'description' => 'If enabled, shows only locations marked as favorite',
                'type'        => 'checkbox',
                'default'     => false,
            ],
        ];
    }

    public function onRun()
    {
        $limit         = (int) $this->property('limit', 0);
        $favoritesOnly = (bool) $this->property('favoritesOnly', false);
        $locale        = app()->getLocale();

        $query = Location::query()
            ->where('locale', $locale)
            ->orderBy('created_at', 'desc');

        if ($favoritesOnly) {
            $query->where('is_favorite', true);
        }

        if ($limit > 0) {
            $query->take($limit);
        }

        $this->locations = $query->get()->map(function ($loc) {
            return [
                'id'      => $loc->id,
                'name'    => $loc->name,
                'address' => $loc->address,
                'slug'    => $loc->slug,
                'thumb'   => $loc->thumb ? $loc->thumb->getThumb(400, 300, ['mode' => 'crop']) : null,
                'url'     => $this->pageUrl('location-details', ['slug' => $loc->slug]),
                'lat'     => $loc->lat,
                'lng'     => $loc->lng,
            ];
        })->toArray();
    }
}
