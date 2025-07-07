<?php

namespace Api\Controllers;

use App\Controller\ApiController;
use App\Models\Book;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Book",
    title: "Book",
    description: "Book model",
    properties: [
        new OA\Property(
            property: "id",
            description: "ID",
            type: "integer",
            example: 1
        ),
        new OA\Property(
            property: "title",
            description: "Название книги",
            type: "string",
            example: "Vel assumenda eum"
        ),
        new OA\Property(
            property: "year",
            description: "Год издания",
            type: "integer",
            example: 2014
        ),
        new OA\Property(
            property: "description",
            description: "Описание книги",
            type: "string",
            example: null,
            nullable: true
        ),
        new OA\Property(
            property: "isbn",
            description: "ISBN",
            type: "string",
            example: "9783264097399"
        ),
        new OA\Property(
            property: "photo_path",
            description: "Путь к обложке книги",
            type: "string",
            example: "/img/book_image.jpg"
        ),
        new OA\Property(
            property: "date_created",
            description: "Дата создания записи",
            type: "string",
            format: "datetime",
            example: "2022-10-23 07:51:37"
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
class BookController extends ApiController
{
    public $modelClass = Book::class;

    #[OA\Get(
        path: "/book",
        summary: "Список книг",
        tags: ["Books"]
    )]
    #[OA\Response(
        response: 200,
        description: "Успешный ответ",
        content: new OA\JsonContent(
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/Book")
        )
    )]
    public function actionIndex()
    {
        return parent::actionIndex();
    }
}
