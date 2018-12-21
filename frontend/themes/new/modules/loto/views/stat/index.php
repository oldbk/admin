<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php Pjax::begin([
    'id' => 'loto-item-grid',
    'timeout' => false,
    'scrollTo' => 1,
]); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Розыгрыши</h5>
            </div>
            <div class="ibox-content">
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
                            'attribute' => 'loto',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'attribute' => 'lotodate',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'label' => 'Затраты',
                            'value' => function($model) {
                                return sprintf('%s екр', (float)$model->sum_ekr);
                            }
                        ],
                        [
                            'label' => 'Себестоимость',
                            'value' => function($model) {
                                if($model->sum_ekr > 0) {
                                    $val = (float)$model->sum_ekr / $model->ticket_count;
                                    return sprintf('%s екр', Yii::$app->formatter->asDecimal($val, 2));
                                }

                                return null;
                            }
                        ],
                        [
                            'attribute' => 'ticket_count',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>