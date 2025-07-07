<?php

$config = [
    'id'                  => 'yii-console',
    'controllerNamespace' => 'Console\Controllers',
    'controllerMap'       => [
        'migrate' => [
            'class'                  => 'yii\console\controllers\MigrateController',
            'templateFile'           => '@App/Migration/migration.php',
        ],
    ],
];

return $config;
