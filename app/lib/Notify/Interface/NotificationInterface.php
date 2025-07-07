<?php

namespace App\Notify\Interface;

interface NotificationInterface
{
    /**
     * Отправляет уведомление
     */
    public function send(string $recipient, array $options = []): bool;

    /**
     * Валидирует получателя для данного канала
     */
    public function validateRecipient(string $recipient): bool;

    /**
     * Возвращает тип канала
     */
    public function getType(): string;
}
