<?php

namespace App\Forms\Book;

use App\Model;
use App\Models\Book;

/**
 * Форма валидации для модели Book
 */
class BookForm extends Model
{
    public ?int $id = null;
    public ?string $title = null;
    public ?int $year = null;
    public ?string $description = null;
    public ?string $isbn = null;
    public ?string $photo_path = null;
    public ?string $date_created = null;
    public ?string $date_updated = null;
    public array $author_ids = [];

    /**
     * @param Book|null $author
     * @param array $config
     */
    public function __construct(?Book $author = null, array $config = [])
    {
        parent::__construct($author, $config);

        if ($author) {
            $this->setAttributes($author->getAttributes(), false);

            $this->author_ids = array_column($author->authors, 'id');
        }
    }

    /**
     * @return array
     */
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

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'photo_path' => 'Путь к фото обложки',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }
}
