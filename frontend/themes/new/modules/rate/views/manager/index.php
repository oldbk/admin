<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\RateManagerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\LaddaAsset::register($this);

?>
<div class="row">
    <p>
        <?= Html::a('Создать', Url::to(['/rate/manager/create']), [
            'class' => 'btn btn-primary',
        ]) ?>
    </p>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список рейтингов</h5>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin([
                    'id' => 'rate-item-grid',
                    'timeout' => false,
                    'scrollTo' => 1,
                ]); ?>
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => false,
                    'options' => [
                        'class' => 'table-responsive'
                    ],
                    'tableOptions' => [
                        'class' => 'table table-striped'
                    ],
                    'summary' => false,
                    'columns' => [
                        [
                            'attribute' => 'name'
                        ],
                        [
                            'attribute' => 'is_enabled',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'format' => 'raw',
                            'value' => function($model) {
                                return $model->is_enabled ? '<span class="label label-success">Да</span>'
                                    : '<span class="label label-danger">Нет</span>';
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '80'],
                            'template' => '{update}{view}',
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>