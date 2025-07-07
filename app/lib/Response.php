<?php

namespace App;

use yii\web\HttpException;

class Response
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * @return self|static
     */
    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $message
     * @throws HttpException
     */
    public function set404($message = '')
    {
        throw new HttpException(404, $message);
    }

    /**
     * @param string $message
     * @throws HttpException
     */
    public function set403($message = ''): void
    {
        throw new HttpException(403, $message);
    }

    /**
     * @return void
     */
    public function setJsonFormat(): void
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    /**
     * @param $data
     * @return void
     */
    public function setXmlFormat($data = null): void
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        if ($data) {
            if (is_array($data)) {
                \Yii::$app->response->data = $data;
            } else {
                \Yii::$app->response->content = $data;
            }
        }
    }

    /**
     * @param $url
     * @param $statusCode
     * @param $checkAjax
     * @return \yii\web\Response|\yii\console\Response|Response
     */
    public function redirect($url, $statusCode = 302, $checkAjax = true): \yii\web\Response|\yii\console\Response|Response
    {
        return \Yii::$app->response->redirect($url, $statusCode, $checkAjax);
    }
}
