<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\dialog\DialogPartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

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
        'id',
        [
            'attribute' => 'bot.name',
            'label' => 'Бот'
        ],
        [
            'attribute' => 'action_type',
            'value' => function($model) {
                return \common\models\dialog\DialogPart::getActions()[$model->action_type];
            }
        ],
        'message:raw',
        [
            'attribute' => 'is_saved',
            'format' => 'raw',
            'value' => function($model) {
                return $model->is_saved ? '<span class="label label-success">Да</span>'
                    : '<span class="label label-danger">Нет</span>';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '100'],
            'template' => '{view} {update} {delete} {up} {down}',
            'buttons' => [
                //view button
                'up' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['/dialog/part/up', 'id' => $model->id], [
                        'title' => 'Move UP',
                    ]);
                },
                'down' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['/dialog/part/down', 'id' => $model->id], [
                        'title' => 'Move DOWN',
                    ]);
                },
            ],
            'visibleButtons' => [
                'up' => function ($model, $key, $index) {
                    return $model->order_position > 1;
                },
                'down' => function ($model, $key, $index) use ($dataProvider) {
                    return $index != $dataProvider->totalCount - 1;
                },
            ]
        ],
    ],
]); ?>