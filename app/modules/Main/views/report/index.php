<?php

use App\Helpers\Url;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var ActiveDataProvider $dataProvider */
/** @var int $selectedYear */
/** @var int[] $allYears */

$this->title = 'Отчет';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="year-filter-block mb-4">
    <h4>Фильтр по годам</h4>
    <div class="btn-group" role="group" aria-label="Кнопки фильтра">
        <?php foreach ($allYears as $year) : ?>
            <?php

            $buttonClass = $year === $selectedYear
                ? 'btn btn-primary'
                : 'btn btn-outline-secondary';

            $url = Url::toRoute(['', 'year' => $year]);
            ?>

            <?= Html::a($year, $url, ['class' => $buttonClass]) ?>

        <?php endforeach; ?>
    </div>
</div>
<div class="author-top-grid">
    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => 'Топ 10 авторов за ' . $selectedYear . ' год',
    'columns' => [
        ['class' => SerialColumn::class],
        [
            'attribute' => 'fio',
            'label' => 'ФИО',
        ],
        [
            'attribute' => 'book_count',
            'label' => 'Издано книг',
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{view}',
            'urlCreator' => static function ($action, $model) {
                if ($action === 'view') {
                    return Url::to(['author/view', 'id' => $model['author_id']]);
                }
                return '';
            },
        ],
    ],
]); ?>

</div>
