<?php

// @codingStandardsIgnoreFile

use App\Models\User;
use App\Request;
use App\Response;
use yii\BaseYii;
use yii\console\Application;
use yii\rbac\DbManager;
use yii\web\Application as AppWeb;

/**
 * Yii is a helper class serving common framework functionality.
 */
class Yii extends BaseYii
{
    /**
     * @var Application|IDECodeAssistHelper_Application the application instance
     */
    public static $app;
}

/**
 * Class IDECodeAssistHelper_Application
 *
 * @property-read \App\Cache\Redis $cache
 * @property-read Request $request
 * @property-read Response $response
 * @property-read DbManager $authManager
 * @property-read IDECodeAssistHelper_User $user
 */
class IDECodeAssistHelper_Application extends AppWeb
{
}

/**
 * Class IDECodeAssistHelper_User
 *
 * @property-read null|User $identity
 */
class IDECodeAssistHelper_User extends \yii\web\User
{
}
