<?php

namespace App\Controller;

use App\Assets\AdminAsset;

class AdminController extends BaseController
{
    public function beforeAction($action)
    {
        AdminAsset::register($this->view);
        return parent::beforeAction($action);
    }
}
