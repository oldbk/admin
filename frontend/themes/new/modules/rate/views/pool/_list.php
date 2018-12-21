<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\pool\PoolAssignSearch */
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
			'attribute' => 'pool_id',
			'headerOptions' => [
				'width' => '90',
			],
			'contentOptions' => [
				'style' => 'text-align:center'
			]
		],
		'pool.name',
		'assignRating.min_position',
		'assignRating.max_position',
		[
			'class' => 'yii\grid\ActionColumn',
			'headerOptions' => ['width' => '100'],
			'template' => '{view} {delete}',
			'buttons' => [
				'view' => function ($url, $model) {
					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/pool/manager/view', 'id' => $model->pool_id], [
						'target' => '_blank',
					]);
				},
			],
		],
	],
]); ?>
