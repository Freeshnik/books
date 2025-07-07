<?php

namespace App\Forms\Book;

use App\Model;
use App\Models\Book;

class BookForm extends Model
{
    public string $title;
    public int $year;
    public ?string $description = null;
    public string $isbn;
    public ?string $photo_path = null;
    public ?string $date_created = null;
    public ?string $date_updated;
    public array $author_ids;

    public function __construct(?Book $book = null, array $config = [])
    {
        parent::__construct($config);

        if ($book) {
            $this->setAttributes($book->getAttributes());

            $this->author_ids = array_column($book->authors, 'id');

//            $this->title = $book->title;
//            $this->year = $book->year;
//            $this->description = $book->description;
//            $this->isbn = $book->isbn;
//            $this->photo_path = $book->photo_path;
//            $this->date_created = $book->date_created;
//            $this->date_updated = $book->date_updated;
//            $this->author_ids = array_column($book->authors, 'id');
        }
    }

    public function rules(): array
    {
        return [
            [['description', 'photo_path', 'date_updated'], 'default', 'value' => null],
            [['title', 'year', 'isbn'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['title', 'isbn', 'photo_path'], 'string', 'max' => 255],
            ['author_ids', 'each', 'rule' => ['integer']],
        ];
    }
}
