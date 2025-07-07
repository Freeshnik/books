<?php

namespace App\Behaviors\Book;

use App\Models\Book;
use App\Models\SubscribeAuthor;
use App\Models\User;
use App\Notify\Factories\NotificationFactory;
use App\Notify\NotificationService;
use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

/** Поведение для отправки уведомления о новой книге всем подписчикам автора
 */
class NewBookNotifyBehavior extends Behavior
{
    public const ID = 'NewBookNotifyBehavior';

    /**
     * Привязка вызова методов по событиям
     * тут можно добавить привязку событий вызывая
     *
     * @return string[]
     */
    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => 'handlerInsert', /** @see self::handlerInsert() */
        ];
    }

    /**
     * @param $event
     * @return void
     */
    public function handlerInsert($event): void
    {
        /** @var Book $owned */
        $owned = $this->owner;
        $subscriberIds = SubscribeAuthor::find()
            ->select(['user_id'])
            ->where(['author_id' => array_column($owned->authors, 'id')])
            ->column();

        if (empty($subscriberIds)) {
            return;
        }

        $notificationService = new NotificationService();
        $userPhones = User::find()->select('id, phone')->where(['id' => $subscriberIds])->indexBy('id')->all();

        foreach ($subscriberIds as $userId) {
            /** @var User $user */
            $user = $userPhones[$userId];

            try {
                $notificationService->send(NotificationFactory::TYPE_SMS, $user->phone, [
                    'user_id' => $user->id,
                    'book_id' => $owned->id,
                ]);
            } catch (\Exception $e) {
                Yii::error([
                    'type' => NotificationFactory::TYPE_SMS,
                    'user_id' => $user->id,
                    'recipient' => $user->phone,
                    'error' => $e->getMessage(),
                ], 'notification_service_error');

                continue;
            }
        }
    }
}
