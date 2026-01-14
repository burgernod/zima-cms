<?php namespace Burgernod\Projects;

use System\Classes\PluginBase;
use Backend;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Projects',
            'description' => 'Manage projects with text, photos, and display on frontend.',
            'author' => 'Burgernod',
            'icon' => 'icon-briefcase'
        ];
    }

    public function registerComponents()
    {
        return [
            'Burgernod\Projects\Components\ProjectList' => 'projectList',
            'Burgernod\Projects\Components\ProjectDetail' => 'projectDetail',

            'Burgernod\Projects\Components\LocationList'   => 'locationList',
            'Burgernod\Projects\Components\LocationDetail' => 'locationDetail',

            'Burgernod\Projects\Components\CommunityList' => 'communityList',
            'Burgernod\Projects\Components\CommunityDetail' => 'communityDetail',
            
            'Burgernod\Projects\Components\ServiceList' => 'serviceList',
            'Burgernod\Projects\Components\ServiceDetail' => 'serviceDetail',
        ];
    }

    public function registerNavigation()
    {
        return [
            'projects' => [
                'label'       => 'Projects',  // This was missing or removed—required for validation
                'url'         => Backend::url('burgernod/projects/projects'),
                'icon'        => 'icon-briefcase',
                'permissions' => ['burgernod.projects.*'],
                'order'       => 500,
                'sideMenu' => [  // Add categories as a submenu
                    'projects_list' => [
                        'label' => 'All Projects',
                        'url' => Backend::url('burgernod/projects/projects'),
                        'icon' => 'icon-list',
                        'permissions' => ['burgernod.projects.*'],
                    ],
                    'categories' => [
                        'label' => 'Categories',
                        'url' => Backend::url('burgernod/projects/categories'),
                        'icon' => 'icon-tags',
                        'permissions' => ['burgernod.projects.*'],
                    ],
                    'locations' => [
                        'label'       => 'Bases',
                        'icon'        => 'icon-map-marker',
                        'url'         => Backend::url('burgernod/projects/locations'),
                        'permissions' => ['burgernod.projects.access_locations'],
                    ],
                    'communities' => [
                        'label'       => 'Communities',
                        'icon'        => 'icon-users',
                        'url'         => Backend::url('burgernod/projects/communities'),
                        'permissions' => ['burgernod.projects.communities.manage']
                    ],
                    'services' => [
                        'label'       => 'Services',
                        'icon'        => 'icon-cogs',
                        'url'         => Backend::url('burgernod/projects/services'),
                        'permissions' => ['burgernod.projects.services.manage']
                    ],
                ],
            ]
        ];
    }

    public function registerPermissions()
    {
        return [
            'burgernod.projects.access_projects' => [
                'tab'   => 'Projects',
                'label' => 'Manage projects'
            ],
            'burgernod.projects.access_locations' => [
                'tab'   => 'Projects',
                'label' => 'Manage locations (bases)'
            ],
            'burgernod.projects.communities.manage' => [
                'tab' => 'Projects',
                'label' => 'Manage communities'
            ],
            'burgernod.projects.services.manage' => [
                'tab' => 'Projects',
                'label' => 'Manage services'
            ],
        ];
    }

    public function boot()
    {
        // Добавляем заголовки к каждому запросу
        \Event::listen('cms.page.response', function($response) {
            $response->header('X-Content-Type-Options', 'nosniff');
            $response->header('X-Frame-Options', 'DENY');
            $response->header('X-XSS-Protection', '1; mode=block');
            $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->header('Content-Security-Policy', "default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;");
        });
    }
}
