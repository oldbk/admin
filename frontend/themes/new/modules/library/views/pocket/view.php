<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

?>


<div class="loto-list-index">
    <p>
        <?= Html::a('Добавить предмет', ['/library/item/create', 'pocket_id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Вернуться', ['index'], ['class' => 'btn btn-default']) ?>
    </p>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список <?= $model->name; ?></h5>
            </div>
            <div class="ibox-content">
		<?php Pjax::begin([
		    'id' => 'library-item-grid',
		    'timeout' => false,
		    'scrollTo' => 1,
		]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout'=>"{pager}\n{items}\n{pager}",
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
                                'style' => 'width: 50px;'
                            ],
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'attribute' => 'name',
			    'label'	=> 'Название',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'attribute' => 'shop_id',
			    'label'	=> 'Магазин',
                            'value' => function($model) use ($shopList) {
                                return $shopList[$model['shop_id']];
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '80'],
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url,$model) {
                                    return Html::a(
                                        '<span class="glyphicon glyphicon-trash"></span>',
                                        ['/library/item/delete', 'id' => $model['id']],
                                        ['class' => 'view-item','data' => ['method' => 'post']]
                                    );
                                },
                            ],
                        ],
                    ],
                ]); ?>
		<?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
