<?php

namespace Console\Controllers;

use App\Jobs\Book\NewBookSmsNotifyJob;
use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\helpers\Console;
use yii\queue\Queue;

class HelloController extends Controller
{
    public function actionInit()
    {
        $this->stdout("Hello World!" . PHP_EOL, Console::BOLD);
    }

    /**
     * @CLI docker exec -it yii2-php php yii hello
     * @return void
     * @throws InvalidConfigException
     */
    public function actionIndex()
    {
        $job = new NewBookSmsNotifyJob([
            'user_id' => 100500,
            'book_id' => 500100,
        ]);

        /** @var Queue $queue */
        $queue = Yii::$app->get('queue');

        $queue->push($job);
    }
}
