<?php

namespace App\Controller;

use App\App;
use App\Models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class MainController extends Controller
{
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => false,
                            'actions' => ['create', 'update', 'delete'],
                            'roles' => ['?'], // Guest users
                            'denyCallback' => function () {
                                throw App::i()->getResponse()->set403('Нет доступа');
                            },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create', 'update', 'delete'],
                            'matchCallback' => function () {
                                return !Yii::$app->user->isGuest && Yii::$app->user->identity->type === User::TYPE_USER;
                            },
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index', 'view'],
                            'roles' => ['@', '?'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
}
