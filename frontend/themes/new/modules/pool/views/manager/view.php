<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\models\pool\PoolPocket;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProviderExport yii\data\ActiveDataProvider */
/* @var $model \common\models\pool\Pool */


\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);
?>


<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Списки</h5>
        </div>
        <div class="ibox-content">
			<?php if($model->pockets): ?>
				<?php foreach ($model->pockets as $Pocket): $pocket_id = $Pocket->id;  ?>
                    <h3><?= $Pocket->description ?> <small>(<?= PoolPocket::getConditions()[$Pocket->condition] ?>) [ID: <?= $Pocket->id ?>]</small></h3>
                    <div>
                        <div>
							<?= Html::a('Удалить список', ['/pool/pocket/delete', 'id' => $Pocket->id], [
								'class' => 'btn btn-xs btn-danger',
								'data' => [
									'confirm' => 'Are you sure you want to delete this item?',
									'method' => 'post',
								],
							]) ?>
                        </div>
						<?= Html::a('Предмет', ['/pool/item/item', 'id' => $Pocket->id], ['class' => 'btn btn-xs btn-primary']) ?>
						<?= Html::a('Репа', ['/pool/item/repa', 'id' => $Pocket->id], ['class' => 'btn btn-xs btn-primary']) ?>
						<?= Html::a('Опыт', ['/pool/item/exp', 'id' => $Pocket->id], ['class' => 'btn btn-xs btn-primary']) ?>
						<?= Html::a('КР', ['/pool/item/kr', 'id' => $Pocket->id], ['class' => 'btn btn-xs btn-primary']) ?>
						<?= Html::a('ЕКР', ['/pool/item/ekr', 'id' => $Pocket->id], ['class' => 'btn btn-xs btn-primary']) ?>
						<?= Html::a('Абилка', ['/pool/item/ability', 'id' => $Pocket->id], ['class' => 'btn btn-xs btn-primary']) ?>
						<?= Html::a('Медаль', ['/pool/item/medal', 'id' => $Pocket->id], ['class' => 'btn btn-xs btn-primary']) ?>
						<?= Html::a('Вес', ['/pool/item/weight', 'id' => $Pocket->id], ['class' => 'btn btn-xs btn-primary']) ?>
						<?= Html::a('Опыт профессий', ['/pool/item/profexp', 'id' => $Pocket->id], ['class' => 'btn btn-xs btn-primary']) ?>
                    </div>
					<?php $RewardProvider = new ArrayDataProvider([
						'allModels' => $Pocket->items,
						'key' => 'id',
					]);
					$RewardProvider->pagination->route = ['/pool/manager/view'];
					?>

					<?= GridView::widget([
						'dataProvider' => $RewardProvider,
						'options' => [
							'class' => 'table-responsive'
						],
						'tableOptions' => [
							'class' => 'table table-striped'
						],
						'summary' => false,
						'columns' => [
							[
								'attribute' => 'info.name',
								'label' => 'Название',
								'value' => function($model) {
									return $model->info->getViewName();
								}
							],
							'give_count',
							[
								'format' => 'raw',
								'label' => 'Валидатор',
								'contentOptions' => ['style' => 'vertical-align:middle;'],
								'value' => function($model) {
									$url = Url::to(['/quest/reward-validator/show', 'id' => $model->id]);
									return $model->info->hasValidatorList()
										? Html::a('Посмотреть', 'javascript:void(0)', [
											'class' => 'btn btn-xs btn-primary show-validator-btn',
											'data-url' => $url,
										]).'<br>Кол-во: '.$model->info->getValidatorCount()
										: 'Отсутствуют';
								}
							],
							[
								'class' => 'yii\grid\ActionColumn',
								'headerOptions' => ['width' => '80'],
								'template' => '{validator}{edit}{delete}',
								'controller' => 'item',
								'buttons' => [
									'edit' => function ($url, $model, $key) use ($pocket_id) {
										$url = Url::toRoute(['/pool/item/'.str_replace('_', '', $model->info->getItemType()), 'id' => $pocket_id, 'item_id' => $model->id]);
										return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
											'title' => \Yii::t('yii', 'Edit'),
										]);
									},
									'validator' => function ($url, $model, $key) {
										$url = Url::toRoute(['/pool/item/form', 'id' => $model->id]);
										return Html::a('<span class="glyphicon glyphicon-bold"></span>', 'javascript:void(0)', [
											'title' => \Yii::t('yii', 'Add validator'),
											'data-url' => $url,
											'class' => 'add-validator-btn',
										]);
									},
								]
							],
						],
					]); ?>
				<?php endforeach; ?>
			<?php else: ?>
                Нет выдаваемой награды...
			<?php endif ?>
        </div>
        <div class="ibox-footer">
			<?= Html::a('Создать список', ['/pool/pocket/create', 'pool_id' => $model->id], ['class' => 'btn btn-success']) ?>
			<?= Html::a('Вернуться', ['/pool/manager/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>