<?php

namespace App\Repositories\Author;

use App\Models\Author;
use App\Models\Book;
use App\Repositories\Repository;

class AuthorRepo extends Repository
{
    /** @var int Количество авторов в топе */
    private const TOP_COUNT = 10;

    /** Возвращает топ-10 авторов, выпустивших наибольшее количество книг в указанном году
     *
     * @param int $year
     * @return array
     */
    public function findTopTenAuthorsByYear(int $year): array
    {
        return Author::find()
            ->select([
                'book_count' => 'COUNT(book_author.id)',
                'book.year',
                'author_id' => 'author.id',
                'author.fio',
            ])
            ->innerJoin('book_author', 'author.id = book_author.author_id')
            ->innerJoin('book', 'book.id = book_author.book_id AND book.year = ' . $year)
            ->groupBy('author.id')
            ->orderBy(['book_count' => SORT_DESC])
            ->limit(self::TOP_COUNT)
            ->asArray()
            ->all();
    }

    /** Возвращает все годы, в которых были изданы книги
     *
     * @return array
     */
    public function getAllYears(): array
    {
        return Book::find()->select('year')->orderBy(['year' => SORT_ASC])->distinct()->column();
    }
}
