<?php

namespace App\Helpers;

class Url extends \yii\helpers\Url
{
    /**
     * Валиден ли урл
     *
     * @param $url
     * @return bool
     */
    public static function isValid($url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Подготовить URL, если у него нету схемы
     *
     * @param $url
     * @return string
     */
    public static function makeValid($url): string
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }

        return $url;
    }

    /**
     * @param $url
     * @return array|string
     */
    public static function getHost($url): array|string|null
    {
        $host = parse_url($url, PHP_URL_HOST);
        return preg_replace('/^www\./', '', $host);
    }
}
