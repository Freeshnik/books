<?php

defined('YII_ENV') || define('YII_ENV', 'dev');
defined('YII_DEBUG') || define('YII_DEBUG', true);

$baseDir = dirname(__DIR__, 2);

require_once $baseDir . '/vendor/autoload.php';
require_once $baseDir . '/vendor/yiisoft/yii2/BaseYii.php';
require_once $baseDir . '/app/lib/Components/stubs/yii_custom_api.php';

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = require $baseDir . '/vendor/yiisoft/yii2/classes.php';
Yii::$container = new yii\di\Container();
