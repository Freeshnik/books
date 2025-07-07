<?php

namespace Main\Controllers;

use App\Services\ReportService;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;

/**
 * Class ReportController - выводит топ AuthorRepo::TOP_COUNT авторов, выпустивших наибольшее количество книг в указанном году
 */
class ReportController extends Controller
{
    /**
     * @throws InvalidConfigException
     */
    public function actionIndex(): string
    {
        $selectedYear = (int) $this->request->getQueryParam('year', 2010);

        $service = Yii::createObject(ReportService::class, ['year' => $selectedYear]);

        $dataProvider = $service->getTopTenAuthorsData();
        $allYears = $service->getAllYears();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'selectedYear' => $selectedYear,
            'allYears' => $allYears,
        ]);
    }
}
