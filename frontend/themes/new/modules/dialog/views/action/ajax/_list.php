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
        [
            'attribute' => 'next_dialog_id',
            'value' => function($model) {
                if($model->next_dialog_id && !$model->nextDialog) {
                    return 'Ошибка. Ссылается на несуществующий диалог';
                }

                /** @var \common\models\DialogAction $model */
                return !$model->nextDialog
                    ? 'Выход' : $model->nextDialog->name.' ('.$model->next_dialog_id.')';
            }
        ],
        'message:raw',
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '80'],
            'template' => '{update} {delete}',
        ],
    ],
]); ?>