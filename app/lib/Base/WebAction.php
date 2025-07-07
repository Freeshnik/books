<?php

namespace App\Base;

use App\ActiveRecord;
use App\Models\User;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller as WebController;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

abstract class WebAction extends BaseAction
{
    public const INVALID_CONTROLLER_ERR = 'Controller must be instance of ' . WebController::class;

    /** @var WebController */
    public $controller;

    /**
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        $this->validateController();
        parent::init();
    }

    /**
     * @throws InvalidConfigException
     */
    protected function validateController(): void
    {
        if (!$this->controller instanceof WebController) {
            throw new InvalidConfigException(self::INVALID_CONTROLLER_ERR);
        }
    }

    public function render(string $view, array $params = []): string
    {
        return $this->controller->render($view, $params);
    }

    public function redirect(string|array $url, int $statusCode = 302): Response
    {
        return $this->controller->redirect($url, $statusCode);
    }

    public function setFlash($key, $message): void
    {
        Yii::$app->session->setFlash($key, $message);
    }

    public function logout(): bool
    {
        return Yii::$app->user->logout();
    }

    public function getCurrentUser(): User|IdentityInterface|null
    {
        return Yii::$app->user->identity;
    }

    public function getRequest(): Request
    {
        return Yii::$app->request;
    }

    public function getResponse(): Response
    {
        return Yii::$app->response;
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($className, int $id): ActiveRecord
    {
        if (($model = $className::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
