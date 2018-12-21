<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LotoItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $last_export string */
?>

<?php Pjax::begin([
    'id' => 'loto-simulation-grid',
    'timeout' => false,
    'scrollTo' => 1,
]); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Результат лото</h5>
            </div>
            <div class="ibox-content">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => [
                        'class' => 'table-responsive',
                    ],
                    'tableOptions' => [
                        'class' => 'table table-striped'
                    ],
                    'summary' => false,
                    'columns' => [
                        [
                            'attribute' => 'bilet',
                            'label' => '№ билета',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'headerOptions' => [
                                'style' => 'text-align:center;'
                            ],
                        ],
                        [
                            'attribute' => 'user_login',
                            'label' => 'Логин',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'headerOptions' => [
                                'style' => 'text-align:center;'
                            ],
                        ],
                        [
                            'attribute' => 'item_name',
                            'label' => 'Выигрыш',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'headerOptions' => [
                                'style' => 'text-align:center;'
                            ],
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
