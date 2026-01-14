<?php namespace Burgernod\Projects\Components;

use Cms\Classes\ComponentBase;
use Burgernod\Projects\Models\Project;
use Cms\Classes\Page;

class ProjectDetail extends ComponentBase
{
    public $project;
    public $translations;

    /**
     * Gets the details for the component
     */
    public function componentDetails()
    {
        return [
            'name' => 'Project Detail',
            'description' => 'Display a single project.'
        ];
    }

    /**
     * Returns the properties provided by the component
     */
    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'Slug',
                'default' => '{{ :slug }}',
                'type' => 'string'
            ]
        ];
    }

    public function onRun()
    {
        $slug = $this->property('slug');
        $project = Project::with(['photos', 'categories'])
            ->where('slug', $slug)
            ->firstOrFail();
        $this->page['project'] =  $project;

        if ($this->project) {
            // Получаем переводы проекта
            $this->translations = $this->project->getTranslations();
            
            // Добавляем текущий проект в переводы
            $allTranslations = $this->translations->put($this->project->locale, $this->project);
            
            // Передаем в page для использования в layout
            $this->page['projectTranslations'] = $allTranslations;
        }
    }
}