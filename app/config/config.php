<?php

use yii\queue\redis\Queue;
use yii\swiftmailer\Mailer;
use yii\log\FileTarget;
use yii\db\Connection;
use yii\rbac\DbManager;

$config = [
    'bootstrap'  => ['log', 'queue'],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'basePath'   => BASE_PATH,
    'timeZone'   => 'Europe/Moscow',
    'name'       => '',
    'components' => [
        'log'         => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'db'          => [
            'class'               => Connection::class,
            'dsn'                 => 'mysql:host=yii2-percona;dbname=book',
            'username'            => 'book',
            'password'            => 'book',
            'charset'             => 'utf8',
            'enableSchemaCache'   => false,
            'schemaCacheDuration' => 60,
            'schemaCache'         => 'cache',
        ],
        'authManager' => [
            'class' => DbManager::class,
            'cache' => 'cache',
        ],
        'mailer'      => [
            'class'            => Mailer::class,
            'useFileTransport' => true,
        ],
//        'cache'       => [
//            'class' => \yii\caching\FileCache::class,
//        ],
        'queue' => [
            'class' => Queue::class,
            'redis' => 'redis',
            'channel' => 'queue',
        ],
        'redis' => [ // Разные БД для кэша и очередей
            'class' => \yii\redis\Connection::class,
            'hostname' => 'yii2-redis',
            'database' => 1,
            'port' => 6379,
            'retries' => 1,
        ],
        'cache' => [
            'class' => \App\Cache\Redis::class,
            'host' => 'yii2-redis',
            'database' => 0,
            'port' => 6379,
        ],
    ],
    'params'     => require(__DIR__ . '/params.php'),
];

return $config;
