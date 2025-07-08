<?php

declare(strict_types=1);

namespace Tests\Acceptance\Api;

use Tests\Support\AcceptanceTester;
use PHPUnit\Framework\Assert;

final class FirstApiTestCest
{
    public function _before(AcceptanceTester $I): void
    {
        // Code here will be executed before each test.
    }

    public function mainPageTest(AcceptanceTester $I): void
    {
        $I->wantTo('Получить ответ по-умолчанию');

        // GET запрос
        $I->sendGET('/');

        // Проверки
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'success' => 'ok',
        ]);
    }

    public function booksTest(AcceptanceTester $I): void
    {
        $I->wantTo('Получить список книг');

        // GET запрос
        $I->sendGET('/book');

        // Проверки
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeHttpHeader('Content-Type', 'application/json; charset=UTF-8');

        $response = $I->grabResponse();
        $books = json_decode($response, true);

        Assert::assertGreaterThan(0, count($books), "Список книг пуст");
    }

    public function authorsTest(AcceptanceTester $I): void
    {
        $I->wantTo('Получить список авторов');

        // GET запрос
        $I->sendGET('/author');

        // Проверки
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeHttpHeader('Content-Type', 'application/json; charset=UTF-8');

        $response = $I->grabResponse();
        $authors = json_decode($response, true);

        Assert::assertGreaterThan(0, count($authors), "Список авторов пуст");
    }

    public function reportTest(AcceptanceTester $I): void
    {
        $I->wantTo('Получить рейтинг Топ 10 авторов');

        // GET запрос
        $I->sendGET('/report');

        // Проверки
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeHttpHeader('Content-Type', 'application/json; charset=UTF-8');

        $response = $I->grabResponse();
        $report = json_decode($response, true);

        Assert::assertGreaterThan(0, count($report['items']), "Рейтинг пуст");
        Assert::assertLessThan(11, count($report['items']), "Рейтинг больше 10 авторов");
    }
}
