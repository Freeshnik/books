<?php

namespace App\Notify\Factories;

use App\Notify\Interface\NotificationInterface;
use App\Notify\Notifications\SmsNotification;
use InvalidArgumentException;

class NotificationFactory
{
    public const TYPE_SMS = 'sms';
    // далее сюда можно добавить email, telegram, whatsapp и т.д.

    public static function create(string $type): NotificationInterface
    {
        return match ($type) {
            self::TYPE_SMS => new SmsNotification(),
            default => throw new InvalidArgumentException("Unsupported notification type: {$type}"),
        };
    }

    /**
     * Возвращает список поддерживаемых типов уведомлений
     */
    public static function getSupportedTypes(): array
    {
        return [
            self::TYPE_SMS,
        ];
    }

    /**
     * Проверяет, поддерживается ли указанный тип
     */
    public static function isSupported(string $type): bool
    {
        return in_array($type, self::getSupportedTypes(), true);
    }
}