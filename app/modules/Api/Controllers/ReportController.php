<?php

namespace Api\Controllers;

use App\Controller\RestController;
use App\Services\ReportService;
use OpenApi\Attributes as OA; // Убедитесь, что этот use есть
use Yii;

// Сначала определим схему для элемента в массиве 'items'
#[OA\Schema(
    schema: "ReportItem",
    title: "Report Item",
    description: "Данные по автору в годовом отчете",
    properties: [
        new OA\Property(
            property: "book_count",
            description: "Количество книг автора за год",
            type: "integer",
            example: 10
        ),
        new OA\Property(property: "year", description: "Год", type: "integer", example: 2010),
        new OA\Property(property: "author_id", description: "ID автора", type: "integer", example: 5),
        new OA\Property(
            property: "fio",
            description: "ФИО автора",
            type: "string",
            example: "Абрам Владимирович Казаков"
        ),
    ],
    type: "object"
)]
// Теперь определим схему для всего ответа целиком
#[OA\Schema(
    schema: "TopAuthorsReport",
    title: "Top Authors Report",
    description: "Отчет по самым публикуемым авторам за год",
    properties: [
        new OA\Property(
            property: "selected_year",
            description: "Выбранный год для отчета",
            type: "integer",
            example: 2010
        ),
        new OA\Property(
            property: "all_years",
            description: "Список всех доступных лет для отчета",
            type: "array",
            items: new OA\Items(type: "integer"),
            example: [2010, 2011, 2012, 2013, 2014, 2015]
        ),
        new OA\Property(
            property: "items",
            description: "Топ 10 авторов за выбранный год",
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/ReportItem")
        ),
    ],
    type: "object"
)]
class ReportController extends RestController
{
    #[OA\Get(
        path: "/report",
        description: "Возвращает список 10 авторов, которые опубликовали больше всего книг за указанный год.",
        summary: "Отчет по 10 самым публикуемым авторам за год",
        tags: ["Reports"]
    )]
    #[OA\Parameter(
        name: "year",
        description: "Год для фильтрации отчета. Если не указан, по умолчанию используется 2010.",
        in: "query",
        required: false,
        schema: new OA\Schema(type: "integer", default: 2010)
    )]
    #[OA\Response(
        response: 200,
        description: "Успешный ответ с данными отчета",
        content: new OA\JsonContent(ref: "#/components/schemas/TopAuthorsReport")
    )]
    public function actionIndex(): array
    {
        $selectedYear = (int) $this->request->getQueryParam('year', 2010);

        $service = Yii::createObject(ReportService::class, ['year' => $selectedYear]);

        $dataProvider = $service->getTopTenAuthorsData();
        $allYears = $service->getAllYears();

        return [
            'selected_year' => $selectedYear,
            'all_years' => $allYears,
            'items' => $dataProvider->getMODels(),
        ];
    }
}
