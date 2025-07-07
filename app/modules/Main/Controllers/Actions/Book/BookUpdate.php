<?php

namespace Main\Controllers\Actions\Book;

use App\Base\WebAction;
use App\Models\Author;
use App\Models\Book;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BookUpdate extends WebAction
{
    /**
     * Displays a single Book model.
     *
     * @param string|int|null $id ID
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function run(string|int|null $id): Response|string
    {
        /** @var Book $book */
        $book = $this->findModel(Book::class, $id);

        if ($this->getRequest()->isPost && $book->load($this->getRequest()->post()) && $book->save()) {
            return $this->redirect(['view', 'id' => $book->id]);
        }

        $allAuthors = Author::find()->select(['fio'])->indexBy('id')->asArray()->column();

        return $this->render('update', [
            'model' => $book,
            'allAuthors' => $allAuthors,
        ]);
    }
}
