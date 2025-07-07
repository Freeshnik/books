<?php

namespace App\Modules;

use App\App;
use App\Models\User;
use App\Statistic\Param;
use yii\base\Module;
use yii\filters\AccessControl;

class AdminModule extends Module
{
    /**
     * Контроллер по умолчанию
     *
     * @var string
     */
    public $defaultRoute = 'site';

    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class'        => AccessControl::class,
                'rules'        => [
                    [
                        'allow'       => true,
                        'controllers' => ['admin/auth'],
                        'actions'     => ['login'],
                        'roles'       => ['?'],
                    ],
                    [
                        'allow'       => true,
                        'controllers' => ['admin/site'],
                        'actions'     => ['logout'],
                        'roles'       => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [User::TYPE_USER],
                    ],
                ],
                'denyCallback' => function () {
                    App::i()->getResponse()->set404();
                },
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->params = [
            'layout_color' => 'blue',
            'module_menu'  => [
                'options' => ['class' => 'sidebar-menu'],
                'items'   => [
                    [
                        'label' => 'Проверенный трафик',
                        'icon'  => 'fa fa-dashboard',
                        'url'   => ['/admin/reports/index'],
                    ],
                    [
                        'label' => 'Статистика за текущий час',
                        'icon'  => 'fa fa-clock-o',
                        'url'   => ['/admin/reports/realtime'],
                    ],
                    [
                        'label' => 'Весь трафик',
                        'icon'  => 'fa fa-line-chart',
                        'url'   => ['#'],
                        'items' => [
                            [
                                'label' => 'По паблишерам',
                                'icon'  => 'fa fa-caret-right',
                                'url'   => ['/admin/reports/publishers'],
                            ],
                            [
                                'label' => 'По дням',
                                'icon'  => 'fa fa-caret-right',
                                'url'   => ['/admin/reports/date'],
                            ],
                            [
                                'label' => 'По платформам',
                                'icon'  => 'fa fa-caret-right',
                                'url'   => ['/admin/reports/platform'],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Проданные показы',
                        'icon'  => 'fa fa-hand-pointer-o',
                        'url'   => ['#'],
                        'items' => [
                            [
                                'label' => 'По паблишерам',
                                'icon'  => 'fa fa-caret-right',
                                'url'   => ['/admin/reports/publishers'],
                            ],
                            [
                                'label' => 'По дням',
                                'icon'  => 'fa fa-caret-right',
                                'url'   => ['/admin/reports/date'],
                            ],
                            [
                                'label' => 'По платформам',
                                'icon'  => 'fa fa-caret-right',
                                'url'   => ['/admin/reports/platform'],
                            ],
                        ],
                    ],
                    [
                        'label' => 'Проекты',
                        'icon'  => 'fa fa-list',
                        'url'   => ['/admin/project'],
                    ],
                ],
            ],
        ];
    }
}
