<?php

namespace Main\Controllers\Actions\Book;

use App\Base\WebAction;
use App\Models\Book;
use App\Repositories\Book\BookRepo;
use DomainException;
use Main\Controllers\BookController;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BookDelete extends WebAction
{
    public function __construct(
        string $id,
        BookController $controller,
        private readonly BookRepo $bookRepo,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function run(int $id): Response
    {
        try {
            $this->bookRepo->delete(Book::class, $id);
        } catch (DomainException $e) {
            Yii::$app->errorHandler->logException($e);
        }

        return $this->redirect(['index']);
    }
}
