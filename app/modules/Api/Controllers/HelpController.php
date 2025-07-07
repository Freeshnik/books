<?php

namespace Api\Controllers;

use yii\rest\Controller;
use yii\web\Response;

class HelpController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        // Переопределяем contentNegotiator, чтобы он всегда отвечал в формате JSON
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
        ];

        return $behaviors;
    }

    public function actionIndex(): array
    {
        return ['success' => 'ok', 'message' => 'This is API'];
    }
}
