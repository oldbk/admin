<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\loto\LotoItem;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AbilityOwnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>


<?php Pjax::begin([
    'id' => 'ability-item-grid',
    'timeout' => false,
    'scrollTo' => 1,
]); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список реликтов</h5>
            </div>
            <div class="ibox-content">
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
                            'attribute' => 'magic_id',
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
                            'attribute' => 'count',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
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
                            'template' => '{update}',
                            'buttons' => [

                            ],
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
