<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\dialog\DialogQuestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?= Html::a('Исправить порядок', ['/dialog/quest/position', 'id' => $searchModel->global_parent_id], ['class' => 'btn btn-primary']) ?>

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
        'order_position',
        [
            'attribute' => 'action_type',
            'value' => function($model) {
                return \common\models\dialog\DialogQuest::getActions()[$model->action_type];
            }
        ],
        'message:raw',
        /*[
            'attribute' => 'is_saved',
            'format' => 'raw',
            'value' => function($model) {
                return $model->is_saved ? '<span class="label label-success">Да</span>'
                    : '<span class="label label-danger">Нет</span>';
            }
        ],*/
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '100'],
            'template' => '{view} {update} {delete} {up} {down}',
            'buttons' => [
                //view button
                'up' => function ($url, $model) use ($dataProvider) {
                    return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['/dialog/quest/up', 'id' => $model->id, 'page' => $dataProvider->pagination->getPage() + 1], [
                        'title' => 'Move UP',
                    ]);
                },
                'down' => function ($url, $model) use ($dataProvider) {
                    return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['/dialog/quest/down', 'id' => $model->id, 'page' => $dataProvider->pagination->getPage() + 1], [
                        'title' => 'Move DOWN',
                    ]);
                },
            ],
            'visibleButtons' => [
                'up' => function ($model, $key, $index) {
                    return $model->order_position > 1;
                },
                'down' => function ($model, $key, $index) use ($dataProvider) {
                    return $model->order_position != $dataProvider->getTotalCount();
                },
            ]
        ],
    ],
]); ?>