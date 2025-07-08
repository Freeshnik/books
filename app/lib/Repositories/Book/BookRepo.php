<?php

namespace App\Repositories\Book;

use App\Forms\Book\BookForm;
use App\Models\Book;
use App\Repositories\Repository;
use RuntimeException;
use yii\db\Exception;

class BookRepo extends Repository
{
    /** Класс модели
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return Book::class;
    }

    /**
     * @param array $conditions
     * @return array
     */
    public function findByConditions(array $conditions): array
    {
        return Book::find()
            ->where($conditions)
            ->all();
    }

    /**
     * @param BookForm $form
     * @return int - ID новой книги
     * @throws Exception
     */
    public function create(BookForm $form): int
    {
        $book = new Book($form->getAttributes());

        if (!$book->save(false)) {
            throw new RuntimeException('Error while saving book.');
        }

        return $book->id;
    }
}
