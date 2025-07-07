<?php

namespace App\Forms\Author;

use App\Model;
use App\Models\Author;

/**
 * Форма валидации для модели Author
 */
class AuthorForm extends Model
{
    public ?int $id = null;
    public ?string $fio = null;
    public ?string $description = null;
    public ?string $date_created = null;
    public ?string $date_updated = null;

    /**
     * @param Author|null $author
     * @param array $config
     */
    public function __construct(?Author $author = null, array $config = [])
    {
        parent::__construct($author);

        if ($author) {
            $this->setAttributes($author->getAttributes(), false);
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['description', 'date_updated'], 'default', 'value' => null],
            [['fio'], 'required'],
            [['description'], 'string'],
            [['date_created', 'date_updated'], 'safe'],
            [['fio'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'description' => 'Описание',
            'date_created' => 'Дата создания',
            'date_updated' => 'Дата обновления',
        ];
    }
}
