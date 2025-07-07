<?php

namespace App\Notify\Notifications;

use App\Jobs\Book\NewBookSmsNotifyJob;
use App\Notify\Factories\NotificationFactory;
use App\Notify\Interface\NotificationInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\queue\Queue;

class SmsNotification implements NotificationInterface
{
    /**
     * @throws InvalidConfigException
     */
    public function send(string $recipient, array $options = []): bool
    {
        $job = new NewBookSmsNotifyJob([
            'user_id' => $options['user_id'], // можно было просто передать $options, но лучше явно для читаемости
            'book_id' => $options['book_id'],
        ]);

        /** @var Queue $queue */
        $queue = Yii::$app->get('queue');

        return (bool) $queue->push($job);
    }

    public function validateRecipient(string $recipient): bool
    {
        $phone = preg_replace('/[^0-9+]/', '', $recipient);
        return strlen($phone) >= 10 && strlen($phone) <= 15;
    }

    public function getType(): string
    {
        return NotificationFactory::TYPE_SMS;
    }
}
