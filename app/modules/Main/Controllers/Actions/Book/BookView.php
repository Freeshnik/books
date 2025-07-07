<?php

namespace Main\Controllers\Actions\Book;

use App\Base\WebAction;
use App\Models\Book;
use App\Models\User;
use Yii;
use yii\web\NotFoundHttpException;

class BookView extends WebAction
{
    /**
     * Displays a single Book model.
     *
     * @param string|int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function run(string|int|null $id): string
    {
        $canManage = !Yii::$app->user->isGuest && Yii::$app->user->identity->type === User::TYPE_USER;

        return $this->render('view', [
            'model' => $this->findModel(Book::class, $id),
            'canManage' => $canManage,
        ]);
    }
}
