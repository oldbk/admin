<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\WordfilterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Чистка форума';
$this->params['breadcrumbs'][] = $this->title;

$fs_a_info = isset(Yii::$app->request->queryParams['ForumSearch']['a_info']) ? Yii::$app->request->queryParams['ForumSearch']['a_info'] : "";
$fs_text = isset(Yii::$app->request->queryParams['ForumSearch']['text']) ? Yii::$app->request->queryParams['ForumSearch']['text'] : "";

?>

<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<div class="forumcleaner-index">
					<?php echo $this->render('_search', ['model' => $searchModel]); ?>

					<?php if ($dataProvider) { echo GridView::widget([
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
								'attribute' => 'a_info',
								'contentOptions' => ['style' => 'width:400px;']
							],
							[
								'attribute' => 'text',
								//'format' => 'raw',
								'contentOptions' => ['style' => 'width:400px;']
							],
							[
								'class' => 'yii\grid\ActionColumn',
								'template' => '{delete}',
								//'contentOptions' => ['style' => 'width:100px;'],
								'buttons' => [
									'delete' => function($url, $model) use($fs_a_info,$fs_text) {
										return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/wordfilter/forumcleaner/delete', 'ForumSearch[a_info]' => $fs_a_info, 'ForumSearch[text]' => $fs_text], [
											'title' => 'Удалить', 'data-confirm' => "Удалить все записи под этот поиск?",'data-method' => 'post']);
									}
								],
							],
						],
					]); } ?>
				</div>

			</div>
		</div>
	</div>
</div>
