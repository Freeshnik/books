<?php

namespace Main\Controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class SwaggerUiController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionJson()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $jsonPath = \Yii::getAlias('@Web/docs/swagger.json');
        if (file_exists($jsonPath)) {
            return json_decode(file_get_contents($jsonPath), true);
        }

        return ['error' => 'Swagger JSON not found'];
    }
}
