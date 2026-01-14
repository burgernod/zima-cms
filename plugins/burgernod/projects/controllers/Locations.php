<?php namespace Burgernod\Projects\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Locations extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.FormController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    /**
     * @var array Permissions required to view this page.
     */
    protected $requiredPermissions = [
        'burgernod.projects.projects.manage_all',
    ];


    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Burgernod.Projects', 'projects', 'locations');
    }
}
