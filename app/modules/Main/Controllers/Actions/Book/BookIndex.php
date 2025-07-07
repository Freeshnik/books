<?php

namespace Main\Controllers\Actions\Book;

use App\Base\WebAction;
use App\Models\BookSearch;
use App\Models\User;
use Main\Controllers\BookController;
use Yii;

class BookIndex extends WebAction
{
    public function __construct(
        string $id,
        BookController $controller,
        private readonly BookSearch $bookSearch,
        array $config = [],
    ) {
        parent::__construct($id, $controller, $config);
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $dataProvider = $this->bookSearch->search($this->getRequest()->getQueryParams());

        $canManage = !Yii::$app->user->isGuest && Yii::$app->user->identity->type === User::TYPE_USER;

        return $this->render('index', [
            'searchModel' => $this->bookSearch,
            'dataProvider' => $dataProvider,
            'canManage' => $canManage,
        ]);
    }
}
