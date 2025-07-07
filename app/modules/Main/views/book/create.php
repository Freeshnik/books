<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var App\Models\Book $model */
/** @var array $allAuthors */

$this->title = 'Создать книгу';
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allAuthors' => $allAuthors,
    ]) ?>

</div>
