<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;
use \common\models\QuestCondition;

/* @var $this yii\web\View */
/* @var $model common\models\Quest */

\frontend\assets\plugins\ICheckAsset::register($this);
\frontend\assets\plugins\PeityAsset::register($this);
\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);
$quest_id = $model->id;
?>
<style>
    #quest-part-block .ajax-loader, #dialog-block .ajax-loader {
        margin-top: 0;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Квест: <?= Html::encode($model->name) ?></h5>
            </div>
            <div class="ibox-content">
                <?php $attributes  = [
                    'id',
                    'name',
                    [
                        'attribute' => 'quest_type',
                        'value' => \common\models\Quest::getTypeList()[$model->quest_type]
                    ]
                ];
                switch ($model->quest_type) {
                    case \common\models\Quest::TYPE_DATERANGE:
                        $attributes = \yii\helpers\ArrayHelper::merge($attributes, [
                            [
                                'attribute' => 'started_at',
                                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            ],
                            [
                                'attribute' => 'ended_at',
                                'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            ]
                        ]);
                        break;
                    case \common\models\Quest::TYPE_INTERVAL:
                        $attributes = \yii\helpers\ArrayHelper::merge($attributes, [
                           'limit_interval'
                        ]);
                        break;
                    case \common\models\Quest::TYPE_LIMITED:
                        $attributes = \yii\helpers\ArrayHelper::merge($attributes, [
                            'limit_count'
                        ]);
                        break;
                }

                $attributes = \yii\helpers\ArrayHelper::merge($attributes, [
                    [
                        'attribute' => 'is_enabled',
                        'format' => 'raw',
                        'value' => $model->is_enabled ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
                    ],
                    [
                        'attribute' => 'is_canceled',
                        'format' => 'raw',
                        'value' => $model->is_canceled ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
                    ],
                    'min_level',
                    'max_level'
                ])
                ?>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes,
                ]) ?>

                <p>
                    <?= Html::a('Экспортировать', 'javascript:void(0)', [
                        'class' => 'btn btn-primary ladda-button',
                        'id' => 'export-btn',
                        'data-url' => Url::to(['/quest/quest/export', 'id' => $model->id]),
                        'data-style' => 'expand-left',
                    ]) ?>
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('Вернуться', ['/quest/quest/index'], ['class' => 'btn btn-default']) ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="quest-condition-index">
    <p>
        <?= Html::a('Квест', ['/quest/condition/quest', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_QUEST], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Медаль', ['/quest/condition/medal', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_QUEST], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Предмет', ['/quest/condition/item', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_QUEST], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Даты', ['/quest/condition/date', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_QUEST], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Кол-во', ['/quest/condition/count', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_QUEST], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Неделя', ['/quest/condition/week', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_QUEST], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Пол', ['/quest/condition/gender', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_QUEST], ['class' => 'btn btn-xs btn-success']) ?>
    </p>
</div>
<div id="quest-condition-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Список условий</h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin([
                'id' => 'quest-condition-grid',
                'enablePushState' => false,
                'scrollTo' => true
            ]); ?>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $provider,
                'options' => [
                    'class' => 'table-responsive'
                ],
                'tableOptions' => [
                    'class' => 'table table-striped'
                ],
                'summary' => false,
                'columns' => [
                    [
                        'attribute' => 'name',
						'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'controller' => '/quest/condition',
                        'buttons' => [
                            'delete' => function($url, $model) use ($quest_id) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/quest/condition/delete', 'group_id' => $model['group'], 'item_id' => $quest_id, 'item_type' => QuestCondition::ITEM_TYPE_QUEST], [
                                    'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);
                            }
                        ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>


<div class="quest-part-index">
    <p>
        <?= Html::a('Создать часть', ['/quest/part/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
</div>
<div id="quest-part-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Список частей</h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin([
                'id' => 'quest-part-grid',
                'enablePushState' => false,
                'scrollTo' => true
            ]); ?>
                <div class="placeholder">
                    <div class="ajax-loader"></div>
                </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<div class="quest-part-index">
    <p>
        <?= Html::a('Добавить реплику', ['/dialog/quest/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Дерево', ['/dialog/tree/index', 'id' => $model->id], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
    </p>
</div>
<div id="dialog-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Список реплик</h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin([
                'id' => 'quest-dialog-grid',
                'enablePushState' => false,
                'scrollTo' => true
            ]); ?>
                <div class="placeholder">
                    <div class="ajax-loader"></div>
                </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<script>
    var $export_btn = $('#export-btn');
    $(function(){
        $export_btn.ladda();
        getParts(1);
        getDialogs(1);

        $(document.body).on('click', '#export-btn', function(){
            var $self = $(this);

            swal({
                title: "Вы уверены?",
                text: 'Запустить процесс экспорта квеста в игру?',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, запустить процесс!",
                closeOnConfirm: false,
                cancelButtonText: 'Отмена',
                showLoaderOnConfirm: true
            }, function () {
                var triggers = {
                    'success'   : 'quest:export:success',
                    'error'     : 'quest:export:complete'
                };
                $ajax.json($self.data('url'),{},'get',triggers);
            });
        });

        $(window).on('quest:export:success', function(e, response) {
            swal("Готово!", "Процесс успешно завершен.", "success");
        });
        $(window).on('quest:export:error', function() {
            swal.close();
        });
    });

    function getParts(page)
    {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/quest/part/list', 'id' => $model->id]) ?>'+'&page='+page,
            success: function (response) {
                $('#quest-part-block .placeholder').html(response);
            }
        });
    }

    function getDialogs(page)
    {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/dialog/quest/list', 'id' => $model->id]) ?>'+'&page='+page,
            success: function (response) {
                $('#dialog-block .placeholder').html(response);
            }
        });
    }

</script>
