![Logo](https://lifebylineblog.wordpress.com/wp-content/uploads/2018/04/cropped-poemicon.png?w=200)

Демо проект "Авторы и их книги"
-------------------
Описание
-------------------
Стек:
- Yii2 (кастомный шаблон Yii2, который отлично подходит для создания моно-репозитория)
- PHP 8.2
- MySQL Percona
- Redis
- Nginx

Основные директории:
- app
- web

Последняя миграция генерирует и вставляет в БД 20 авторов и 500 книг.

Контроллеры выполнены в трёх разных стилях:
1) Обычный Yii2 - всё к экшен методах. Пример: AuthController и AuthorController
2) Экшен как отдельный класс. Механика экшена выполняется в методе run. Можно прокидывать зависимость в конструкторе. Пример: BookController -> BookIndex и др.
3) Обычный Yii2, но с вынесением логики в сервис + репозиторий (при большом кол-ве параметров стоит добавить класс-форму для их валидации, но в report контроллере я не делал форму из-за малого кол-ва параметров) Пример: ReportController.
   Из трёх форм предпочитаю 3-ю.

Отправка уведомления - через очереди в Redis:
Статус очереди: docker exec -it yii2-php php yii queue
Разовый запуск: docker exec -it yii2-php php yii queue/run
В режиме прослушивания: docker exec -it yii2-php php yii queue/listen

Система уведомлений создана при помощи фабрики.

Коменды:
PHP CS Fixer: 
~~~
docker exec -it yii2-php ./vendor/bin/php-cs-fixer fix app
~~~

PHPStan:
~~~
docker exec -it yii2-php vendor/bin/phpstan analyse app
~~~

-------------------
TODO
-------------------
- тесты


-------------------
Установка
-------------------
Скопируйте файл окружения:
~~~
cp .env.dist .env
~~~

Установите PHP-пакеты с помощью Composer:
~~~
docker run --rm -v $(pwd):/app composer install --ignore-platform-reqs
~~~

Запустите сборку и контейнеры Docker:
~~~
docker compose up -d --build
~~~

Выполните миграции базы данных:
~~~
docker exec -it yii2-php php yii migrate --interactive=0
~~~

Можно открывать: [localhost](http://localhost/),

Топ 10 авторов за год: [localhost/report](http://localhost/report),

API: [Localhost:8080/book](http://localhost:8080/book)

Документация Swagger (не полная): [http://localhost/swagger-ui/](http://localhost/swagger-ui/)

Yii2 Basic Project Template turned into mono repository
-------------------