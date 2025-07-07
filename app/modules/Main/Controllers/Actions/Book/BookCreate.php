<?php

namespace Main\Controllers\Actions\Book;

use App\Base\WebAction;
use App\Forms\Book\BookForm;
use App\Models\Author;
use App\Repositories\Book\BookRepo;
use Main\Controllers\BookController;
use yii\web\Response;

class BookCreate extends WebAction
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
     * @return Response|string
     * @throws \yii\db\Exception
     */
    public function run(): Response|string
    {
        $bookForm = new BookForm();

        if ($this->getRequest()->isPost && $bookForm->load($this->getRequest()->post()) && $bookForm->validate()) {
            $bookId = $this->bookRepo->create($bookForm);
            if ($bookId) {
                return $this->redirect(['view', 'id' => $bookId]);
            }
        }

        $allAuthors = Author::find()->select(['fio'])->indexBy('id')->asArray()->column();

        return $this->render('create', [
            'model' => $bookForm,
            'allAuthors' => $allAuthors,
        ]);
    }
}
