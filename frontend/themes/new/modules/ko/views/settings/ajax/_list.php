<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\QuestPartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'class' => 'table-responsive'
    ],
    'tableOptions' => [
        'class' => 'table table-striped'
    ],
    'summary' => false,
    'columns' => [
        [
            'label' => 'Поле',
            'format' => 'html',
            'value' => function($model) {
                return $this->render('_item', ['models' => $model->items]);
            }
        ],
		[
			'label' => 'Значение',
			'format' => 'html',
			'value' => function($model) {
				return $this->render('_item2', ['models' => $model->items]);
			}
		],
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['width' => '100'],
            'template' => '{update} {clone} {delete}',
            'buttons' => [
				'clone' => function ($url, $model, $key) {
					return Html::a('<i class="fa fa-copy"></i>', ['/ko/settings/clone', 'id' => $model->main_id, 'group_id' => $model->group_id]);
				},
				'update' => function ($url, $model, $key) {
					return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/ko/settings/update', 'id' => $model->main_id, 'group_id' => $model->group_id]);
				},
				'delete' => function ($url, $model, $key) {
					return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/ko/settings/delete', 'id' => $model->main_id, 'group_id' => $model->group_id], [
					    'data-confirm' => 'Are you sure you want to delete this item?',
                        'data-method' => 'post'
                    ]);
				},
            ],
        ],
    ],
]); ?>
