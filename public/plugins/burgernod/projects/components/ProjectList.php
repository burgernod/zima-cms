<?php namespace Burgernod\Projects\Components;

use Cms\Classes\ComponentBase;
use Burgernod\Projects\Models\Project;

class ProjectList extends ComponentBase
{
    public $projects;

    public function componentDetails()
    {
        return [
            'name'        => 'Project List',
            'description' => 'Display a list of projects.'
        ];
    }

    public function defineProperties()
    {
        return [
            'limit' => [
                'title'       => 'Limit',
                'description' => 'Number of projects to display',
                'type'        => 'string',
                'default'     => 6,
                'validation'  => 'integer|min:1'
            ],
            'favoritesOnly' => [
                'title'       => 'Show only favorite projects',
                'description' => 'If enabled, shows only projects marked as favorite',
                'type'        => 'checkbox',
                'default'     => false,
            ],
        ];
    }

    public function onRun()
    {
        $limit = $this->property('limit', 6);
        $favoritesOnly = (bool) $this->property('favoritesOnly', false);
        $locale = app()->getLocale();

        $query = Project::query()
            ->with(['thumb', 'categories']) // 👈 ВАЖНО
            ->where('locale', $locale)
            ->orderBy('created_at', 'desc');

        if ($favoritesOnly) {
            $query->where('is_favorite', true);
        }

        if ($limit > 0) {
            $query->limit($limit);
        }

        $projects = $query
            ->orderBy('created_at', 'desc')
            ->get();

        $this->projects = $projects->map(function ($project) {

            return [
                'id'          => $project->id,
                'language '   => $project->locale,
                'title'       => $project->title,
                'slug'        => $project->slug,
                'location'    => $project->location,
                'year'        => $project->year,
                'description' => strip_tags($project->description),
                'thumb' => $project->thumb
                                    ? $project->thumb->getThumb(400, 300, ['mode' => 'crop'])
                                    : null,
                'url'         => $this->pageUrl('project-details', ['slug' => $project->slug]),
                'categories'  => $project->categories->pluck('name')->toArray(),
            ];
        })->toArray();
    }
}