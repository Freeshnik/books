<?php

namespace App\Models;

use App\ActiveRecord;
use App\Behaviors\Timestamp;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * @property int $id
 * @property string $fio - ФИО автора
 * @property string|null $description - биография автора
 * @property string|null $date_created
 * @property string|null $date_updated
 * @property-read Book[] $books - массив книг автора
 * @property-read SubscribeAuthor|null $userSubscription - массив подписчиков на автора. Используется в уведомлениях
 * @property-read bool $isSubscribedByCurrentUser Виртуальное свойство. Показывает, подписан ли текущий юзер на этого автора
 */
class Author extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'author';
    }

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            Timestamp::class,
        ]);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'description' => 'Описание',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable(BookAuthor::tableName(), ['author_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserSubscription(): ActiveQuery
    {
        if (Yii::$app->user->isGuest) {
            return $this->hasOne(SubscribeAuthor::class, ['author_id' => 'id'])->where('1=0');
        }

        return $this->hasOne(SubscribeAuthor::class, ['author_id' => 'id'])
            ->andOnCondition(['user_id' => Yii::$app->user->id]);
    }

    /**
     * @return bool
     */
    public function getIsSubscribedByCurrentUser(): bool
    {
        return $this->userSubscription !== null;
    }
}
