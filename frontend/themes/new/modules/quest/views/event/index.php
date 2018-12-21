<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\QuestCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


\frontend\assets\plugins\LaddaAsset::register($this);
?>
<div class="quest-list-index">
    <?= Html::a('Создать событие', ['create'], ['class' => 'btn btn-success']) ?>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список событий</h5>
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
                        'id',
                        'name',
                        'quest_ids',
                        [
                            'label' => '',
                            'format' => 'raw',
                            'value' => function($model) {
                                return Html::a('Экспортировать', 'javascript:void(0);', [
                                    'class' => 'btn btn-xs btn-primary ladda-button',
                                    'id' => 'export-btn',
                                    'data-url' => Url::to(['/quest/event/export', 'id' => $model->id]),
                                    'data-style' => 'expand-left',
                                ]);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '80'],
                            'template' => '{update}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<script>
    var $export_btn = $('#export-btn');
    $(function(){
        $export_btn.ladda();

        $(document.body).on('click', '#export-btn', function(){
            var $self = $(this);

            var triggers = {
                'success'   : 'quest:event:export:success',
                'error'     : 'quest:event:export:complete'
            };

            $export_btn.ladda('start');
            $ajax.json($self.data('url'),{},'get',triggers);
        });

        $(window).on('quest:event:export:success', function(e, response) {
            $export_btn.ladda('stop');
        });
        $(window).on('quest:event:export:error', function() {
            $export_btn.ladda('stop');
        });
    });
</script>