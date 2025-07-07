<?php

use App\Forms\Author\AuthorForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var AuthorForm $model */

$this->title = 'Обновить автора: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="author-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
