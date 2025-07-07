<?php

namespace Main\Controllers\Actions\Book;

use App\Base\WebAction;
use App\Forms\Book\BookForm;
use App\Models\Author;
use yii\web\Response;

class BookCreate extends WebAction
{
    /**
     * @return Response|string
     */
    public function run(): Response|string
    {
        $bookForm = new BookForm();

        if ($this->getRequest()->isPost) {
            if ($bookForm->load($this->getRequest()->post()) && $bookForm->validate()) {


                return $this->redirect(['view', 'id' => $bookForm->id]);
            }
        } else {
            $bookForm->loadDefaultValues();
        }

        $allAuthors = Author::find()->select(['fio'])->indexBy('id')->asArray()->column();

        return $this->render('create', [
            'model' => $bookForm,
            'allAuthors' => $allAuthors,
        ]);
    }
}
