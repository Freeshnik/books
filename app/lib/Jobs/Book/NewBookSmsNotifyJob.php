<?php

namespace App\Jobs\Book;

use App\Models\Book;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use RuntimeException;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\RetryableJobInterface;

/**
 * Job-класс для отправки СМС-уведомления о новом книге автора.
 *
 * @CLI docker exec -it yii2-php php yii queue - статус
 *
 * @CLI docker exec -it yii2-php php yii queue/run - одиночный запуск
 * @CLI docker exec -it yii2-php php yii queue/listen - запуск в режиме прослушивания
 */
class NewBookSmsNotifyJob extends BaseObject implements JobInterface, RetryableJobInterface
{
    /** API KEY в .env по хорошему надо */
    public const API_KEY = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';

    private const MAX_RETRIES = 10;
    private const REQUEST_TIMEOUT = 10;

    public int $user_id;
    public int $book_id;

    public function execute($queue): void
    {
        $user = User::findOne($this->user_id);
        /** @var Book $book */
        $book = Book::find()->where(['id' => $this->book_id])->with('authors')->one();

        // Критическая ошибка - не повторяем
        if (!$user || !$book) {
            Yii::error([
                'error' => 'Пользователь или книга не найдены',
                'user_id' => $this->user_id,
                'book_id' => $this->book_id,
            ], 'sms_book_notification_error');

            // При InvalidArgumentException задача не будет отправлена в retry
            throw new InvalidArgumentException('Пользователь или книга не найдены');
        }

        // Проверяем валидность телефона
        if (!$this->isValidPhone($user->phone)) {
            Yii::error([
                'error' => 'Неверный номер телефона',
                'phone' => $user->phone,
                'user_id' => $this->user_id,
            ], 'sms_book_notification_error');

            throw new InvalidArgumentException('Неверный номер телефона');
        }

        $client = new Client();
        $query = $this->buildQuery($book, $user);

        try {
            $response = $client->get('https://smspilot.ru/api.php', [
                'query' => $query,
                'timeout' => self::REQUEST_TIMEOUT,
                'connect_timeout' => self::REQUEST_TIMEOUT,
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            // Проверяем HTTP статус
            if ($statusCode >= 400) {
                throw new RuntimeException("HTTP bad response: {$statusCode}");
            }

            Yii::info([
                'status' => $statusCode,
                'response' => $body,
                'phone' => $user->phone,
                'book_id' => $this->book_id,
            ], 'sms_book_notification');
        } catch (GuzzleException $e) {
            Yii::error([
                'error' => $e->getMessage(),
                'phone' => $user->phone,
                'book_id' => $this->book_id,
                'attempt' => $queue->attempts,
            ], 'sms_book_notification_error');

            // Выбрасываем исключение для повторной попытки
            throw new RuntimeException('SMS sending failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Проверяет валидность номера телефона
     */
    private function isValidPhone(string $phone): bool
    {
        $cleanPhone = preg_replace('/[^0-9+]/', '', $phone);
        return strlen($cleanPhone) >= 10 && strlen($cleanPhone) <= 15;
    }

    /**
     * @param Book $book
     * @param User $user
     * @return array
     */
    public function buildQuery(Book $book, User $user): array
    {
        $message = 'Вышла новая книга "' . $book->title . '" от автора(ов): '
            . implode(', ', array_column($book->authors, 'fio'));

        return [
            'send' => $message,
            'to' => str_replace('+', '', $user->phone),
            'apikey' => self::API_KEY,
            'format' => 'json',
        ];
    }

    /**
     * Максимальное количество попыток (Time to retry)
     */
    public function getTtr(): int
    {
        return 5 * 60; // 5 минут
    }

    /**
     * Количество попыток при неудаче
     */
    public function canRetry($attempt, $error): bool
    {
        if ($attempt >= self::MAX_RETRIES) {
            return false;
        }

        // Не повторяем при критических ошибках (неверные данные)
        if ($error instanceof InvalidArgumentException) {
            return false;
        }

        return true;
    }
}
