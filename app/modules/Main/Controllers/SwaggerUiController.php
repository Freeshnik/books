<?php

namespace Main\Controllers;

use yii\web\Controller;

class SwaggerUiController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionJson()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $jsonPath = \Yii::getAlias('@Web/docs/swagger.json');
        if (file_exists($jsonPath)) {
            return json_decode(file_get_contents($jsonPath), true);
        }

        return ['error' => 'Swagger JSON not found'];
    }
}
