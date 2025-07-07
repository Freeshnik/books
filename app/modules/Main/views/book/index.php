<?php

use App\Models\Book;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var App\Models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var bool $canManage */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($canManage) : ?>
            <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => \yii\grid\SerialColumn::class],
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
                        'style' => 'width:100px; height:auto;', // или используйте 'class'
                    ]);
                }

                return '';
            },
        ],
        'date_created',
            //'date_updated',
        [
            'class' => ActionColumn::class,
            'urlCreator' => static function ($action, Book $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            },
            'visibleButtons' => [
                'update' => $canManage,
                'delete' => $canManage,
            ],
        ],
    ],
]); ?>


</div>
