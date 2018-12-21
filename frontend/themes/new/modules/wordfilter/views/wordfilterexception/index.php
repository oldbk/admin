<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\WordfilterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\AwesomeCheckboxAsset::register($this);

$this->title = 'Слова-исключения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wordfilterexception-list-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Добавить слово', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Удалить всё', ['deleteall'], ['class' => 'btn btn-success','data-confirm' => "Удалить все записи?"]) ?>
    </p>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
		    <h5><?= Html::encode($this->title) ?></h5>
            </div>
            <div class="ibox-content">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
	'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','contentOptions' => ['style' => 'width:20px;']],
            [
		'attribute' => 'id',
		'contentOptions' => ['style' => 'width:30px;']
	    ],
            [
		'attribute' => 'word', 
		'contentOptions' => ['style' => 'width:400px;']
	    ],
            [
		'contentOptions' => ['style' => 'width:50px;'],
   		'checkboxOptions' => function($model, $key, $index, $column) {
             		$bool = $model->incsearch;
             		return ['checked' => $bool];
    		},
		'header' => "Искать вхождение?",
		'class' => \yii\grid\CheckboxColumn::className(),
	    ],
            [           
		'class' => 'yii\grid\ActionColumn',
		'template' => '{delete}',
		//'contentOptions' => ['style' => 'width:100px;'],
		'buttons' => [
			'delete' => function($url, $model) {
				return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/wordfilter/wordfilterexception/delete', 'id' => $model->id], [
				'title' => 'Удалить', 'data-confirm' => "Удалить запись?",'data-method' => 'post']);
			}
		],
	    ],
        ],
    ]); ?>
            </div>
        </div>
    </div>
</div>