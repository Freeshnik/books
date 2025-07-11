<?php

use App\Forms\Book\BookForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var BookForm $model */
/** @var array $allAuthors */

$this->title = 'Обновить книгу: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allAuthors' => $allAuthors,
    ]) ?>

</div>
