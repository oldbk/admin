<?php

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<?php Pjax::begin([
    'id' => 'plugin-other-grid',
    'timeout' => false,
    'scrollTo' => 1,
]); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Пользователи других плагинов</h5>
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
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['width' => '80'],
                                'template' => '{update}',
                                'buttons' => [

                                    //view button
                                    'update' => function ($url, $model) {
                                        return \yii\bootstrap\Html::a(
                                            '<span class="glyphicon glyphicon-list-alt"></span>',
                                            ['/plugin/clear', 'id' => $model->id],
                                            [
                                                'title' => 'Очистить',
                                                'data-pjax' => 0
                                            ]
                                        );
                                    },
                                ],
                            ],
                            [
                                'attribute' => 'login',
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
                                'contentOptions' => [
                                    'style' => 'text-align:center'
                                ],
                            ],
                            [
                                'attribute' => 'finish_interval',
                                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                                'contentOptions' => [
                                    'style' => 'text-align:center'
                                ],
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
                            [
                                'attribute' => 'change_host',
                                'format' => 'raw',
                                'value' => function($model){
                                    return $model->change_host ? '<span class="label label-success">Да</span>'
                                        : '<span class="label label-danger">Нет</span>';
                                }
                            ],
                            [
                                'attribute' => 'change_host_count',
                                'contentOptions' => [
                                    'style' => 'text-align:center'
                                ],
                            ],
                            [
                                'attribute' => 'total_check_host',
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