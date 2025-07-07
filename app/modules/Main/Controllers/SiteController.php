<?php

namespace Main\Controllers;

use App\Controller\BaseController;

class SiteController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
