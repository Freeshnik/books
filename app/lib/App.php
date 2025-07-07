<?php

namespace App;

use yii\base\Module;
use yii\caching\CacheInterface;
use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

final class App
{
    /**
     * @var App|null
     */
    protected static App|null $instance = null;

    /**
     * @var array
     */
    protected mixed $config;

    /**
     * @return App
     */
    public static function i(): App
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @param string $module_name
     * @return array|mixed
     */
    public function getConfig($module_name = MODULE_NAME)
    {
        if (empty($this->config[$module_name])) {
            $app_config    = require dirname(__DIR__) . '/config/config.php';
            $module_config = $local_config = [];

            $config_file_module = dirname(__DIR__) . '/config/modules/' . $module_name . '.php';
            if (is_file($config_file_module) && is_readable($config_file_module)) {
                $module_config = require dirname(__DIR__) . '/config/modules/' . $module_name . '.php';
            }
            $config_file_local = dirname(__DIR__) . '/config/config_local.php';
            if (is_file($config_file_local) && is_readable($config_file_local)) {
                $local_config = require dirname(__DIR__) . '/config/config_local.php';
            }
            $this->config[$module_name] = ArrayHelper::merge(
                $app_config,
                $module_config,
                $local_config
            );
        }
        return $this->config[$module_name];
    }

    /**
     * @return \yii\console\Application|\yii\web\Application
     */
    public function getApp(): \yii\web\Application|\yii\console\Application
    {
        return \Yii::$app;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return Request::i();
    }

    public function getResponse()
    {
        return Response::i();
    }

    /**
     * @return Connection
     */
    public function getDb(): Connection
    {
        return \Yii::$app->db;
    }

    /**
     * @return CacheInterface
     */
    public function getCache(): CacheInterface
    {
        return \Yii::$app->cache;
    }

    /**
     * @return IdentityInterface
     */
    public function getCurrentUser(): IdentityInterface
    {
        return \Yii::$app->user->identity;
    }

    /**
     * @return Module
     */
    public function getCurrentModule(): Module
    {
        return \Yii::$app->controller->module;
    }

    public function getFaceDomain(): string
    {
        return \Yii::$app->params['domains']['face'];
    }

    /**
     * @param string $message
     * @param string $type
     */
    public function setFlash(string $message, $type = 'success'): void
    {
        \Yii::$app->getSession()->setFlash($type, $message);
    }

    /**
     * @return array
     */
    public function getFlashes(): array
    {
        return \Yii::$app->getSession()->getAllFlashes();
    }
}
