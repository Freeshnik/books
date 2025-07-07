<?php

use App\Models\User;

$config = [
    'id' => 'yii',
    'language' => 'ru-RU',
    'controllerNamespace' => 'Main\Controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
//    'modules' => [
//        'admin' => [
//            'class' => \App\Modules\AdminModule::class,
//            'controllerNamespace' => 'Admin\Controllers',
//            'viewPath' => '@Admin/views',
//        ],
//    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD]
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'Fds-55Urn8O98Lij5GkSMCBSgKwGpaD14',
        ],
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'loginUrl' => '/login'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'admin/introduce' => 'admin/auth/login',
                'logout' => '/auth/logout',
                'api-docs' => 'swagger-ui/index',
                'api-docs/json' => 'swagger-ui/json',
            ],
        ],

    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;