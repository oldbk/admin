<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\pool\PoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);


?>
<div class="loto-list-index">
    <p>
        <?= Html::a('Создать новый список', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Списки призов</h5>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin([
                    'id' => 'pool-grid',
                    'timeout' => false,
                    'scrollTo' => 1,
                ]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
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
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'label' => 'Связи',
                            'format' => 'raw',
                            'value' => function($model) {
                                /** @var \common\models\pool\Pool $model */
                                $string = '';
                                foreach ($model->assigns as $Assign) {
                                    $string .= Html::tag('span', $Assign->target_name, ['class' => 'badge badge-success']);
                                }

                                return $string;
                            }
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            'filter' => false,
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '80'],
                            'template' => '{view} {clone} {update}',
                            'buttons' => [
                                'clone' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<i class="fa fa-copy"></i>',
                                        ['/pool/manager/clone', 'id' => $model->id],
                                        ['title' => 'Клонировать']
                                    );
                                },
                            ]
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>