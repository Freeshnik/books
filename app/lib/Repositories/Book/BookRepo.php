<?php

namespace App\Repositories\Book;

use App\Models\Book;
use App\Repositories\Repository;
use RuntimeException;
use yii\db\Exception;

class BookRepo extends Repository
{
    /**
     * @param Book $model
     * @return int - ID новой книги
     * @throws Exception
     */
    public function create(Book $model): int
    {
        if ($model->save(false)) {
            throw new RuntimeException('Saving error.');
        }

        return $model->id;
    }
}