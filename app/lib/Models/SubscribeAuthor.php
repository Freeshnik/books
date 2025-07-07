<?php

namespace App\Models;

use yii\db\ActiveQuery;

/**
 * @info Модель для отслеживания подписки на автора
 * This is the model class for table "subscribe_author".
 * @property int $id
 * @property int $author_id
 * @property int $user_id
 * @property string|null $date_created
 *
 * @property Author $author
 * @property User $user
 */
class SubscribeAuthor extends \App\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%subscribe_author}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['author_id', 'user_id'], 'required'],
            [['author_id', 'user_id'], 'integer'],
            [['date_created'], 'safe'],
            [['author_id', 'user_id'], 'unique', 'targetAttribute' => ['author_id', 'user_id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'user_id' => 'User ID',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
