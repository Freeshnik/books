<?php

namespace Main\Controllers\Actions\Book;

use App\Base\WebAction;
use App\Forms\Book\BookForm;
use App\Models\Author;
use App\Models\Book;
use App\Repositories\Book\BookRepo;
use Main\Controllers\BookController;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BookUpdate extends WebAction
{
    public function __construct(
        string $id,
        BookController $controller,
        private readonly BookRepo $bookRepo,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    /** Выводит страницу книги
     *
     * @param int $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function run(int $id): Response|string
    {
        /** @var Book $book */
        $book = $this->bookRepo->findOneByConditions(Book::class, ['id' => $id]);
        if (!$book) {
            throw new NotFoundHttpException('Book not found.');
        }

        $form = new BookForm($book);

        if ($this->getRequest()->isPost && $form->load($this->getRequest()->post()) && $form->validate()) {
            $book = $this->bookRepo->update($book);

            return $this->redirect(['view', 'id' => $book->id]);
        }

        $allAuthors = Author::find()->select(['fio'])->indexBy('id')->asArray()->column();

        return $this->render('update', [
            'model' => $form,
            'allAuthors' => $allAuthors,
        ]);
    }
}
