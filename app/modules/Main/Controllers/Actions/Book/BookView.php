<?php

namespace Main\Controllers\Actions\Book;

use App\Base\WebAction;
use App\Models\Book;
use App\Models\User;
use App\Repositories\Book\BookRepo;
use Main\Controllers\BookController;
use Yii;
use yii\web\NotFoundHttpException;

class BookView extends WebAction
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
     * Displays a single Book model.
     *
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function run(int $id): string
    {
        $canManage = !Yii::$app->user->isGuest && Yii::$app->user->identity->type === User::TYPE_USER;

        $book = $this->bookRepo->findOneByConditions(Book::class, ['id' => $id]);
        if (!$book) {
            throw new NotFoundHttpException('Book not found.');
        }

        return $this->render('view', [
            'model' => $book,
            'canManage' => $canManage,
        ]);
    }
}
