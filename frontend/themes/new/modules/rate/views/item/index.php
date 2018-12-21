<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\TopListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\LaddaAsset::register($this);

?>
<div class="row">
    <p>
        <?= Html::a('Очистить кэш', 'javascript:void(0);', [
            'class' => 'btn btn-primary ladda-button',
            'id' => 'cache-btn',
            'data-url' => Url::to(['/rate/item/cache']),
            'data-style' => 'expand-left',
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
                            'template' => '{update}',
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    var $cache_btn = $('#cache-btn');
    $(function() {
        $cache_btn.ladda();

        $(document.body).on('click', '#cache-btn', function(){
            var $self = $(this);
            $self.ladda( 'start' );

            var triggers = {
                'success'   : 'rate:cache:success',
                'error'     : 'rate:cache:complete'
            };
            $ajax.json($self.data('url'),{},'get',triggers);
        });

        $(window).on('rate:cache:success', function(e, response) {
            $cache_btn.ladda( 'stop' );
        });
        $(window).on('rate:cache:error', function() {
            $cache_btn.ladda( 'stop' );
        });
    });
</script>