<?php

namespace Main\Controllers\Actions\Book;

use App\Base\WebAction;
use App\Models\Book;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BookDelete extends WebAction
{
    /**
     * @param string|int $id
     * @return Response
     * @throws \Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function run(string|int|null $id): Response
    {
        $this->findModel(Book::class, $id)->delete();

        return $this->redirect(['index']);
    }
}
