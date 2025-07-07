<?php

use App\Models\User;
use yii\web\JsonParser;
use yii\web\Response;


return [
    'id'                  => 'api',
    'controllerNamespace' => 'Api\Controllers',
    'defaultRoute'        => 'help/index',
    'components'          => [
        'user'         => [
            'identityClass' => User::class,
            'enableSession' => false,
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
        ],
        'response'     => [
            'format' => Response::FORMAT_JSON,
            'class' => Response::class,
        ],
        'request'      => [
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
            'parsers'                => [
                'application/json' => JsonParser::class,
            ],
        ],
    ],
];