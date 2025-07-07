<?php

use App\Models\Book;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var App\Models\Book $model */
/** @var bool $canManage */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($canManage): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'year',
            [
                'label' => 'Авторы',
                'format' => 'raw',
                'value' => static function ($model) {
                    /** @var Book $model */
                    if ($model->authors) {
                        $result = [];
                        foreach ($model->authors as $author) {
                            $result[] = '[' . $author->id . '] ' . Html::a($author->fio, '/author/view?id=' . $author->id, ['target' => '_blank']);
                        }

                        return implode(', ', $result);
                    }

                    return '';
                },
            ],
            'description:ntext',
            'isbn',
            [
                'attribute' => 'photo_path',
                'label' => 'Обложка',
                'format' => 'raw', // ВАЖНО: 'raw' или 'html', чтобы теги не экранировались
                'value' => static function ($model) {
                    if ($model->photo_path) {
                        return Html::img($model->photo_path, [
                            'alt' => 'Обложка книги',
                            'style' => 'width:100px; height:auto;' // или используйте 'class'
                        ]);
                    }

                    return '';
                },
            ],
            'date_created',
            'date_updated',
        ],
    ]) ?>

</div>
