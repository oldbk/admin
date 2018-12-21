<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\QuestPartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?= Html::a('Исправить порядок', ['/quest/part/position', 'id' => $searchModel->quest_id], ['class' => 'btn btn-primary']) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => [
        'class' => 'table-responsive'
    ],
    'tableOptions' => [
        'class' => 'table table-striped'
    ],
    'summary' => false,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => [
                'width' => '90',
            ],
            'contentOptions' => [
                'style' => 'text-align:center'
            ]
        ],
        [
            'attribute' => 'part_number',
            'headerOptions' => [
                'width' => '90',
            ],
            'contentOptions' => [
                'style' => 'text-align:center'
            ]
        ],
        'name',
        'weight',
        'description',
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '100'],
            'template' => '{view} {update} {delete} {up} {down}',
            'buttons' => [
                //view button
                'up' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['/quest/part/up', 'id' => $model->id], [
                        'title' => 'Move UP',
                    ]);
                },
                'down' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['/quest/part/down', 'id' => $model->id], [
                        'title' => 'Move DOWN',
                    ]);
                },
            ],
            'visibleButtons' => [
                'up' => function ($model, $key, $index) {
                    return $model->part_number > 1;
                },
                'down' => function ($model, $key, $index) use ($dataProvider) {
                    return $model->part_number != $dataProvider->totalCount;
                },
            ]
        ],
    ],
]); ?>
