<?php

namespace Api\Controllers;

use App\Controller\ApiController;
use App\Models\Author;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Author",
    title: "Author",
    description: "Модель автора",
    properties: [
        new OA\Property(
            property: "id",
            description: "ID",
            type: "integer",
            example: 1
        ),
        new OA\Property(
            property: "fio",
            description: "ФИО автора",
            type: "string",
            example: "Николай Дмитриевич Новиков"
        ),
        new OA\Property(
            property: "description",
            description: "Описание/биография",
            type: "string",
            example: "Dolorum molestiae laudantium atque eos eius iure rerum dolorem iusto sit eum sed minus magnam."
        ),
        new OA\Property(
            property: "date_created",
            description: "Дата создания записи",
            type: "string",
            format: "datetime",
            example: "2016-07-26 05:56:44"
        ),
        new OA\Property(
            property: "date_updated",
            description: "Дата обновления записи",
            type: "string",
            format: "datetime",
            example: null,
            nullable: true
        ),
    ],
    type: "object"
)]
class AuthorController extends ApiController
{
    public $modelClass = Author::class;

    #[OA\Get(
        path: "/author",
        summary: "Список авторов",
        tags: ["Authors"]  // Логичнее использовать тег "Authors", а не "Books"
    )]
    #[OA\Response(
        response: 200,
        description: "Успешный ответ",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/Author")
        )
    )]
    public function actionIndex()
    {
        return parent::actionIndex();
    }
}
