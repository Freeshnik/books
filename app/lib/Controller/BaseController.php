<?php

namespace App\Controller;

use App\App;
use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if ($this->getRequest()->isAjax()) {
            $this->getResponse()->setJsonFormat();
        }

        return parent::beforeAction($action);
    }

    public function goHome()
    {
        $user = $this->getCurrentUser();
        if ($user) {
            return $this->getResponse()->redirect($user->getBaseUrl());
        }

        return $this->getResponse()->redirect('/');
    }

    public function getRequest()
    {
        return App::i()->getRequest();
    }

    public function getResponse()
    {
        return App::i()->getResponse();
    }

    public function getCurrentUser()
    {
        return App::i()->getCurrentUser();
    }
}
