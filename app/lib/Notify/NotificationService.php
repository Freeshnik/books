<?php

namespace App\Notify;

use App\Notify\Factories\NotificationFactory;

class NotificationService
{
    /**
     * Отправляет уведомление через указанный канал
     */
    public function send(string $type, string $recipient, array $options = []): bool
    {
        return NotificationFactory::create($type)->send($recipient, $options);
    }
}