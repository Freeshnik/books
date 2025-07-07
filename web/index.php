<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('MODULE_NAME') or define('MODULE_NAME', 'main');
defined('BASE_PATH') or define('BASE_PATH', dirname(__DIR__) . '/app/modules/Main');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');


require(dirname(__DIR__). '/app/config/bootstrap.php');

$config = \App\App::i()->getConfig();

(new yii\web\Application($config))->run();
