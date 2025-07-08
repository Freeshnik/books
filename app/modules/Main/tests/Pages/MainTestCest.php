<?php

declare(strict_types=1);

namespace Main\tests\Pages;

use Tests\Support\AcceptanceTester;

final class MainTestCest
{
    public function _before(AcceptanceTester $I): void
    {
        // Code here will be executed before each test.
    }

    public function PagesTest(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Авторы и их книги');

        $I->amOnPage('/author');
        $I->see('Авторы');

        $I->amOnPage('/book');
        $I->see('Книги');

        $I->amOnPage('/report');
        $I->see('Отчет');

        $I->amOnPage('/auth/login');
        $I->see('Авторизация');

        $I->amOnPage('/auth/signup');
        $I->see('Регистрация');
    }

    public function LoginTest(AcceptanceTester $I): void
    {
        $I->wantTo('Выполнить вход с правильными учетными данными и выйти');

        $I->amOnPage('/auth/login');

        // Проверяем, что форма загружена
        $I->seeElement('#login-form');

        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'admin');

        // Отправляем форму
        $I->click('button[name="login-button"]');

        $I->seeInCurrentUrl('/');
        $I->see('Выход (admin)');

        $I->seeInCurrentUrl('/');
        $I->see('Выход (admin)');

        $I->click('Выход (admin)');
        $I->seeInCurrentUrl('/');
        $I->see('Регистрация');
    }
}
