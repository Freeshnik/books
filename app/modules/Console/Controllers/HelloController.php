<?php

namespace Console\Controllers;

use App\Jobs\Book\NewBookSmsNotifyJob;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class HelloController extends Controller
{
    public function actionInit()
    {
        $this->stdout("Hello World!" . PHP_EOL, Console::BOLD);
    }

    /**
     * @CLI docker exec -it yii2-php php yii hello
     * @return void
     */
    public function actionIndex()
    {
        $job = new NewBookSmsNotifyJob([
            'user_id' => 100500,
            'book_id' => 500100,
        ]);

        Yii::$app->queue->push($job);
    }
}
