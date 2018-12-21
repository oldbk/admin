<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use \common\models\oldbk\StaticMessage;

/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\StaticMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="message-list-index">
    <p>
        <?= Html::a('Добавить сообщение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Сообщения</h5>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin([
                    'id' => 'message-grid',
                    'timeout' => false,
                    'scrollTo' => 1,
                ]); ?>
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
                            'attribute' => 'id',
                            'headerOptions' => [
                                'style' => 'width: 50px;'
                            ],
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'message_type',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'value' => function($model) {
                                return StaticMessage::getTypeList()[$model->message_type];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'message_type', StaticMessage::getTypeList(), ['class'=>'form-control','prompt' => '']),
                        ],
                        [
                            'attribute' => 'must_send',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            'filter' => false,
                            'value' => function($model) {
                                if(!$model->must_send) {
                                    return null;
                                }

                                return Yii::$app->formatter->asDate($model->must_send, 'dd.MM.Y HH:mm:ss');
                            }
                        ],
                        [
                            'attribute' => 'day_interval',
                            'value' => function($model) {
                                if(!$model->day_interval) {
                                    return null;
                                }

                                return sprintf(' %d дн.', $model->day_interval);
                            }
                        ],
                        [
                            'attribute' => 'message',
                            'format' => 'html',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'is_fixed',
                            'format' => 'html',
                            'value' => function($model) {
                                return $model->is_fixed ? '<span class="label label-success">Да</span>'
                                    : '<span class="label label-danger">Нет</span>';
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '80'],
                            'template' => '{update} {delete}',
                            'buttons' => [

                            ]
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
