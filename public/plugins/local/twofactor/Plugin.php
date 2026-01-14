<?php

namespace Local\TwoFactor;

use Backend\Facades\Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * TwoFactor Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'local.twofactor::lang.plugin.name',
            'description' => 'local.twofactor::lang.plugin.description',
            'author'      => 'Local',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register(): void
    {

    }

    /**
     * Boot method, called right before the request route.
     */
    public function boot(): void
    {

    }

    /**
     * Registers any frontend components implemented in this plugin.
     */
    public function registerComponents(): array
    {
        return []; // Remove this line to activate

        return [
            \Local\TwoFactor\Components\MyComponent::class => 'myComponent',
        ];
    }

    /**
     * Registers any backend permissions used by this plugin.
     */
    public function registerPermissions(): array
    {
        return []; // Remove this line to activate

        return [
            'local.twofactor.some_permission' => [
                'tab' => 'local.twofactor::lang.plugin.name',
                'label' => 'local.twofactor::lang.permissions.some_permission',
                'roles' => [UserRole::CODE_DEVELOPER, UserRole::CODE_PUBLISHER],
            ],
        ];
    }

    /**
     * Registers backend navigation items for this plugin.
     */
    public function registerNavigation(): array
    {
        return []; // Remove this line to activate

        return [
            'twofactor' => [
                'label'       => 'local.twofactor::lang.plugin.name',
                'url'         => Backend::url('local/twofactor/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['local.twofactor.*'],
                'order'       => 500,
            ],
        ];
    }
}
