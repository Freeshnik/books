<?php

namespace App\Behaviors;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Timestamp extends TimestampBehavior
{
    /**
     * Название поля с датой создания
     *
     * @var string
     */
    public $createdAtAttribute = 'date_created';

    /**
     * Название поля с датой апдейта
     *
     * @var string
     */
    public $updatedAtAttribute = 'date_updated';

    /**
     * @var mixed
     */
    public $value;

    /**
     * Указываем какое значение использовать
     *
     * @inheritdoc
     */
    protected function getValue($event)
    {
        return $this->value = new Expression('NOW()');
    }
}
