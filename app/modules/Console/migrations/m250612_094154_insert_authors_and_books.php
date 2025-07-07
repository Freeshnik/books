<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use yii\db\Migration;

class m250612_094154_insert_authors_and_books extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete(Author::tableName());
        $this->delete(Book::tableName());
        $this->delete(BookAuthor::tableName());

        try {
            $faker = \Faker\Factory::create('ru_RU');
        } catch (\Exception $e) {
            echo "Error: The Faker library is not installed. Please run 'composer require fzaninotto/faker' in your project root.\n";
            return false;
        }

        $authorsData = [];
        $authorCount = 20;
        echo "Generating {$authorCount} authors...\n";

        for ($i = 0; $i < $authorCount; $i++) {
            $authorsData[] = [
                'fio' => $faker->name,
                'description' => $faker->optional(0.7)->sentence(15, true),
                'date_created' => $faker->dateTimeThisDecade->format('Y-m-d H:i:s'),
                'date_updated' => null,
            ];
        }

        $this->batchInsert(Author::tableName(), ['fio', 'description', 'date_created', 'date_updated'], $authorsData);

        $authorIds = Author::find()->select('id')->column();
        if (empty($authorIds)) {
            echo "Warning: No author IDs found. Cannot insert books.\n";
            return false;
        }

        $booksData = $bookAuthorData = [];
        $bookCount = 500;

        $years = [2010, 2011, 2012, 2013, 2014, 2015];

        for ($i = 0; $i < $bookCount; $i++) {
            $booksData[] = [
                'title' => rtrim($faker->sentence(mt_rand(2, 5)), '.'),
                'year' => $years[array_rand($years)],
                'description' => $faker->optional(0.8)->paragraph(3, true),
                // @phpstan-ignore-next-line
                'isbn' => $faker->isbn13,
                'photo_path' => '/img/book_image.jpg',
                'date_created' => $faker->dateTimeThisDecade->format('Y-m-d H:i:s'),
                'date_updated' => null,
            ];
        }

        $this->batchInsert(Book::tableName(), ['title', 'year', 'description', 'isbn', 'photo_path', 'date_created', 'date_updated'], $booksData);

        $bookIds = Book::find()->select('id')->column();
        if (empty($bookIds)) {
            echo "Warning: No book IDs found. Cannot insert books authors.\n";
            return false;
        }

        foreach ($bookIds as $bookId) {
            $randomAuthorId = $authorIds[array_rand($authorIds)];
            $bookAuthorData[] = [
                'book_id' => $bookId,
                'author_id' => $randomAuthorId,
            ];

            $anotherRandomAuthorId = $authorIds[array_rand($authorIds)];
            if ($anotherRandomAuthorId !== $randomAuthorId) { // Добавляем случайного автора не ко всем книгам
                $bookAuthorData[] = [
                    'book_id' => $bookId,
                    'author_id' => $anotherRandomAuthorId,
                ];
            }
        }

        $this->batchInsert(BookAuthor::tableName(), ['book_id', 'author_id'], $bookAuthorData);
    }

    public function safeDown(): void
    {
        $this->delete(Author::tableName());
        $this->delete(Book::tableName());
        $this->delete(BookAuthor::tableName());
    }
}
