<?php

use App\Models\Author;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var App\Models\AuthorSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var bool $canManage */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($canManage) : ?>
            <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>


    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => SerialColumn::class],
        'id',
        'fio',
        'description:text',
        'date_created',
        'date_updated',
        [
            'attribute' => 'userSubscription',
            'label' => 'Subscription Status',
            'format' => 'raw',
            'value' => static function ($model) {
                /** @var Author $model */
                if ($model->isSubscribedByCurrentUser) {
                    return '<span class="label label-success pb-lg-5">You are subscribed</span>'
                        . '<p>' . Html::a(
                            'Отписаться',
                            ['subscription/delete', 'author_id' => $model->id],
                            [
                                'class' => 'btn btn-alert btn-xs',
                                'data-method' => 'POST',
                            ]
                        ) . '</p>';
                }

                if (!Yii::$app->user->isGuest) {
                    return Html::a(
                        'Подписаться',
                        ['subscription/create', 'author_id' => $model->id],
                        [
                            'class' => 'btn btn-primary btn-xs',
                            'data-method' => 'POST',
                        ]
                    );
                }

                return 'Только для авторизированных пользователей';
            },
            'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
            'filter' => false,
        ],
        [
            'class' => ActionColumn::class,
            'urlCreator' => static function ($action, Author $model, $key, $index, $column) {
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
