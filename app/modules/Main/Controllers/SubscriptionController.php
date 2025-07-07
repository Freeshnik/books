<?php

namespace Main\Controllers;

use App\Models\SubscribeAuthor;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

class SubscriptionController extends Controller
{
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'create' => ['POST'],
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /** Метод подписки на автора
     *
     * @param int $author_id
     * @return Response
     * @throws Exception
     * @throws HttpException
     */
    public function actionCreate(int $author_id)
    {
        $params = [
            'author_id' => $author_id,
            'user_id' => Yii::$app->user->id,
        ];

        $model = new SubscribeAuthor();

        if ($model->load($params, '') && $model->save()) {
            return $this->redirect(['author/index']);
        }

        throw new BadRequestHttpException('Ошибка при попытке подписаться: ' . implode(', ', $model->getErrorSummary(true)), 400);
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $author_id)
    {
        $model = SubscribeAuthor::findOne(['user_id' => Yii::$app->user->id, 'author_id' => $author_id]);
        if ($model) {
            $model->delete();
        }

        return $this->redirect(['author/index']);
    }
}
