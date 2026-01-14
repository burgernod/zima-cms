<?php namespace Burgernod\Projects\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendMenu;

class Communities extends Controller
{
    public $implement = [
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.FormController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    protected $requiredPermissions = ['burgernod.projects.communities.manage'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Burgernod.Projects', 'projects', 'communities');
    }
}
