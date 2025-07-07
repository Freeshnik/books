<?php

namespace Console\Controllers;

use OpenApi\Generator;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class SwaggerController extends Controller
{
    /**
     * Генерирует и сохраняет openapi.json файл.
     */
    public function actionGenerate(): int
    {
        $generator = new Generator();
        // Путь к папке с контроллерами API
        $openapi = $generator->generate([
            Yii::getAlias('@App/Controller'),
            Yii::getAlias('@Api/Controllers'),
        ]);
        //        $openapi = Generator::scan([
        //            \Yii::getAlias('@App/Controller'), // или @frontend/controllers
        //            \Yii::getAlias('@Api/Controllers'), // если используете модели
        //        ]);

        // Путь для сохранения JSON файла
        $jsonPath = \Yii::getAlias('@Web/docs/swagger.json');
        file_put_contents($jsonPath, $openapi->toJson());

        echo "Swagger документация сгенерирована: " . $jsonPath . "\n";

        return ExitCode::OK;
    }
}
