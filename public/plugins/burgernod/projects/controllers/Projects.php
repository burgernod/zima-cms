<?php

namespace Burgernod\Projects\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

/**
 * Projects Backend Controller
 */
class Projects extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    /**
     * @var array Permissions required to view this page.
     */
    protected $requiredPermissions = [
        'burgernod.projects.projects.manage_all',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Burgernod.Projects', 'projects');
    }
}
