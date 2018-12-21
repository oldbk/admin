<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php Pjax::begin([
    'id' => 'plugin-link-grid',
    'timeout' => false,
    'scrollTo' => 1,
]); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Ссылки</h5>
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
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['width' => '80'],
                                'template' => '{update}',
                                'buttons' => [

                                    //view button
                                    'update' => function ($url, $model) {
                                        return \yii\bootstrap\Html::a(
                                            '<span class="glyphicon glyphicon-list-alt"></span>',
                                            ['/plugin/change', 'id' => $model->id, 'type' => 'link'],
                                            [
                                                'title' => 'Изменить',
                                                'data-pjax' => 0
                                            ]
                                        );
                                    },
                                ],
                            ],
                            [
                                'attribute' => 'src',
                                'contentOptions' => [
                                    'style' => 'text-align:center'
                                ],
                            ],
                            [
                                'attribute' => 'is_correct',
                                'format' => 'raw',
                                'value' => function($model){
                                    return $model->is_correct ? '<span class="label label-success">Да</span>'
                                        : '<span class="label label-danger">Нет</span>';
                                }
                            ],
                            [
                                'attribute' => 'data',
                                'label' => 'Ссылки',
                                'format' => 'raw',
                                'value' => function($model) {
                                    $data = unserialize($model->data);
                                    $string = '';
                                    foreach ($data as $_item) {
                                        $string .= $_item.'<br>';
                                    }
                                    return $string;
                                }
                            ],
                        ],
                    ]); ?>

                </div>
            </div>
        </div>
    </div>
<?php Pjax::end(); ?>