<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use \common\models\questPocket\QuestPocket;
use common\models\QuestCondition;

/* @var $this yii\web\View */
/* @var $model common\models\QuestPart */
/* @var $gift_items array */
/* @var $get_validators array */

\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\ICheckAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);

$part_id = $model->id;
?>
<style>
    .validator-form-add {
        display: none;
        width: 300px;
    }
    #quest-task-block .ajax-loader, #part-dialog-block .ajax-loader {
        margin-top: 0;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Квест: "<?= $model->quest->name; ?>" Часть: "<?= Html::encode($model->name) ?>"</h5>
            </div>
            <div class="ibox-content">
                <?php $attributes = [
                    'id',
                    [
                        'attribute' => 'quest.name',
                        'label' => 'Квест'
                    ],
                    'name',
                    'description:raw',
                    'chat_start:raw',
                    'chat_end:raw',
                    [
                        'attribute' => 'is_auto_finish',
                        'format' => 'raw',
                        'value' => $model->is_auto_finish ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
                    ],
					[
						'attribute' => 'is_auto_start',
						'format' => 'raw',
						'value' => $model->is_auto_start ? '<span class="label label-success">Да</span>'
							: '<span class="label label-danger">Нет</span>'
					],
                    'part_number',
                    'weight',
                    'description_type'
                ];
                ?>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes,
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('Вернуться', ['/quest/quest/view', 'id' => $model->quest_id], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>

    <div class="quest-condition-index">
        <p>
            <?= Html::a('Уровень', ['/quest/condition/level', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_PART], ['class' => 'btn btn-xs btn-success']) ?>
            <?= Html::a('Склонность', ['/quest/condition/align', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_PART], ['class' => 'btn btn-xs btn-success']) ?>
            <?= Html::a('Уровень профессий', ['/quest/condition/prof', 'item_id' => $model->id, 'item_type' => QuestCondition::ITEM_TYPE_PART], ['class' => 'btn btn-xs btn-success']) ?>
        </p>
    </div>
    <div id="part-condition-block">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Список условий</h5>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin([
                    'id' => 'part-condition-grid',
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
                                'delete' => function($url, $model) use ($part_id) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/quest/condition/delete', 'group_id' => $model['group'], 'item_id' => $part_id, 'item_type' => QuestCondition::ITEM_TYPE_PART], [
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

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Награда</h5>
            </div>
            <div class="ibox-content">
                <?php if($model->pocketRewards): ?>
                    <?php foreach ($model->pocketRewards as $PocketReward): $pocket_id = $PocketReward->id; ?>
                        <h3><?= $PocketReward->name ?> <small>(<?= QuestPocket::getConditions()[$PocketReward->condition] ?>) [ID: <?= $PocketReward->id ?>]</small></h3>
                        <div>
                            <div>
                                <?= Html::a('Удалить список', ['/quest/pocket-part/delete', 'id' => $PocketReward->id], [
                                    'class' => 'btn btn-xs btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                            <?= Html::a('Предмет', ['/quest/part-reward/item', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                            <?= Html::a('Репа', ['/quest/part-reward/repa', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                            <?= Html::a('Опыт', ['/quest/part-reward/exp', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                            <?= Html::a('КР', ['/quest/part-reward/kr', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                            <?= Html::a('ЕКР', ['/quest/part-reward/ekr', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                            <?= Html::a('Абилка', ['/quest/part-reward/ability', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                            <?= Html::a('Медаль', ['/quest/part-reward/medal', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                            <?= Html::a('Вес', ['/quest/part-reward/weight', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                            <?= Html::a('Опыт профессий', ['/quest/part-reward/profexp', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        </div>
                        <?php $RewardProvider = new ArrayDataProvider([
                            'allModels' => $PocketReward->pocketItems,
                            'key' => 'id',
                        ]);
                        $RewardProvider->pagination->route = ['/quest/part/view'];
                        ?>

                        <?= GridView::widget([
                            'dataProvider' => $RewardProvider,
                            'options' => [
                                'class' => 'table-responsive'
                            ],
                            'tableOptions' => [
                                'class' => 'table table-striped'
                            ],
                            'summary' => false,
                            'columns' => [
                                [
                                    'attribute' => 'info.name',
                                    'label' => 'Название',
                                    'value' => function($model) {
                                        return $model->info->getViewName();
                                    }
                                ],
                                'count',
                                [
                                    'format' => 'raw',
                                    'label' => 'Валидатор',
                                    'contentOptions' => ['style' => 'vertical-align:middle;'],
                                    'value' => function($model) {
                                        $url = Url::to(['/quest/reward-validator/show', 'id' => $model->id]);
                                        return $model->info->hasValidatorList()
                                            ? Html::a('Посмотреть', 'javascript:void(0)', [
                                                'class' => 'btn btn-xs btn-primary show-validator-btn',
                                                'data-url' => $url,
                                            ]).'<br>Кол-во: '.$model->info->getValidatorCount()
                                            : 'Отсутствуют';
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '80'],
                                    'template' => '{validator}{edit}{delete}',
                                    'controller' => 'part-reward',
                                    'buttons' => [
                                        'edit' => function ($url, $model, $key) use ($pocket_id) {
                                            $url = Url::toRoute(['/quest/part-reward/'.str_replace('_', '', $model->info->getItemType()), 'id' => $pocket_id, 'item_id' => $model->id]);
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                'title' => \Yii::t('yii', 'Edit'),
                                            ]);
                                        },
                                        'validator' => function ($url, $model, $key) {
                                            $url = Url::toRoute(['/quest/reward-validator/form', 'id' => $model->id]);
                                            return Html::a('<span class="glyphicon glyphicon-bold"></span>', 'javascript:void(0)', [
                                                'title' => \Yii::t('yii', 'Add validator'),
                                                'data-url' => $url,
                                                'class' => 'add-validator-btn',
                                            ]);
                                        },
                                    ]
                                ],
                            ],
                        ]); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    Нет выдаваемой награды...
                <?php endif ?>
            </div>
            <div class="ibox-footer">
                <?= Html::a('Создать список', ['/quest/pocket-part/reward', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>


    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Изымаемое <small>(необязательное присутствие в рюкзаке. Если есть, тогда изымается)</small></h5>
            </div>
            <div class="ibox-content">
                <?php if($model->pocketTakes): ?>
                    <?php foreach ($model->pocketTakes as $PocketReward): ?>
                        <h3><?= $PocketReward->name ?> <small>(<?= QuestPocket::getConditions()[$PocketReward->condition] ?>) [ID: <?= $PocketReward->id ?>]</small></h3>
                        <div>
                            <div>
                                <?= Html::a('Удалить список', ['/quest/pocket-part/delete', 'id' => $PocketReward->id], [
                                    'class' => 'btn btn-xs btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                            <?= Html::a('Предмет', ['/quest/part-take/item', 'id' => $PocketReward->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        </div>
                        <?php $RewardProvider = new ArrayDataProvider([
                            'allModels' => $PocketReward->pocketItems,
                            'key' => 'id',
                        ]);
                        $RewardProvider->pagination->route = ['/quest/part/view'];
                        ?>
                        <?= GridView::widget([
                            'dataProvider' => $RewardProvider,
                            'options' => [
                                'class' => 'table-responsive'
                            ],
                            'tableOptions' => [
                                'class' => 'table table-striped'
                            ],
                            'summary' => false,
                            'columns' => [
                                [
                                    'attribute' => 'info.name',
                                    'label' => 'Название',
                                    'value' => function($model) {
                                        return $model->info->getViewName();
                                    }
                                ],
                                'count',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['width' => '80'],
                                    'template' => '{delete}',
                                    'controller' => 'part-take'
                                ],
                            ],
                        ]); ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    Нет изымаемого...
                <?php endif ?>
            </div>
            <div class="ibox-footer">
                <?= Html::a('Создать список', ['/quest/pocket-part/take', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="validator-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div data-js="validator-modal-content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                <button type="button" data-style="expand-left" id="validator-add-btn" class="ladda-button btn btn-primary">Добавить</button>
            </div>
        </div>
    </div>
</div>

<div id="quest-task-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Список заданий</h5>
        </div>
        <div class="ibox-content">
            <?php if($model->pocketTasks): ?>
                <?php foreach ($model->pocketTasks as $PocketTask):
                    $pocket_id = $PocketTask->id;
                    ?>
                    <h3><?= $PocketTask->name ?> <small>(<?= QuestPocket::getConditions()[$PocketTask->condition] ?>) [ID: <?= $PocketTask->id ?>]</small></h3>
                    <div>
                        <div>
                            <?= Html::a('Удалить список', ['/quest/pocket-part/delete', 'id' => $PocketTask->id], [
                                'class' => 'btn btn-xs btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?= Html::a('Привязать диалог завершение', ['/quest/pocket-part/dialog-finish', 'id' => $PocketTask->id], [
                                'class' => 'btn btn-xs btn-danger',
                            ]) ?>
                        </div>
                        <h5>Диалог</h5>
                        <?php if($PocketTask->dialogFinish): ?>
                            <?= $PocketTask->dialogFinish->name; ?>
                            <?= Html::a('x', ['/quest/pocket-part/delete-dialog', 'id' => $PocketTask->id], [
                                'class' => 'btn btn-xs btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php else: ?>
                            Привязанных диалогов нет
                        <?php endif; ?>
                        <h5>Общие</h5>
                        <hr style="margin: 10px 0;">
                        <?= Html::a('Дроп', ['/quest/part-task/drop', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        <?= Html::a('Предмет', ['/quest/part-task/item', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        <?= Html::a('Бой', ['/quest/part-task/fight', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        <?= Html::a('Подарок', ['/quest/part-task/gift', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        <?= Html::a('Магия', ['/quest/part-task/magic', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        <?= Html::a('Событие\Действие', ['/quest/part-task/event', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        <?= Html::a('ХП по наминалу', ['/quest/part-task/hill', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        <?= Html::a('Вес', ['/quest/part-task/weight', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        <?= Html::a('Покупка', ['/quest/part-task/buy', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        <!--
                        <h5>Убийство</h5>
                        <hr style="margin: 10px 0;">
                        <?= Html::a('Бота', ['/quest/part-task/kill-bot', 'id' => $PocketTask->id], ['class' => 'btn btn-xs btn-primary']) ?>
                        -->
                    </div>
                    <?php $RewardProvider = new ArrayDataProvider([
                        'allModels' => $PocketTask->pocketItems,
                        'key' => 'id',
                    ]);
                    $RewardProvider->pagination->route = '/quest/part/view';
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $RewardProvider,
                        'options' => [
                            'class' => 'table-responsive'
                        ],
                        'tableOptions' => [
                            'class' => 'table table-striped'
                        ],
                        'summary' => false,
                        'columns' => [
                            'id',
                            [
                                'attribute' => 'info.name',
                                'label' => 'Название',
                                'value' => function($model) {
                                    return $model->info->getViewName();
                                },
                                'contentOptions' => ['style' => 'max-width: 200px;word-break: break-word;']
                            ],
                            [
                                'attribute' => 'info.item_type',
                                'format' => 'raw',
                                'label' => 'Тип',
                                'value' => function($model) {
                                    return $model->info->getTitle();
                                }
                            ],
                            [
								'attribute' => 'count',
								'format' => 'raw',
								'value' => function($model) {
									return sprintf('%d/%d', $model->info->start_count, $model->count);
								}
                            ],
							[
								'attribute' => 'info.can_be_multiple',
								'format' => 'raw',
								'label' => 'Сочетается с другими',
								'value' => function($model) {
									return $model->info->can_be_multiple ? '<span class="label label-success">Да</span>'
										: '<span class="label label-danger">Нет</span>';
								},
								'contentOptions' => ['style' => 'text-align:center;'],
								'headerOptions' => ['style' => 'width: 220px;'],
							],
                            [
                                'format' => 'raw',
                                'label' => 'Валидатор',
                                'contentOptions' => ['style' => 'vertical-align:middle;'],
                                'value' => function($model) {
                                    $url = Url::to(['/quest/task-validator/show', 'id' => $model->id]);
                                    return $model->info->hasValidatorList()
                                        ? Html::a('Посмотреть', 'javascript:void(0)', [
                                            'class' => 'btn btn-xs btn-primary show-validator-btn',
                                            'data-url' => $url,
                                        ]).'<br>Кол-во: '.$model->info->getValidatorCount()
                                        : 'Отсутствуют';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'headerOptions' => ['width' => '80'],
                                'template' => '{validator}{edit}{delete}',
                                'controller' => 'part-task',
                                'buttons' => [
                                    'validator' => function ($url, $model, $key) {
                                        $url = Url::toRoute(['/quest/task-validator/form', 'id' => $model->id]);
                                        return Html::a('<span class="glyphicon glyphicon-bold"></span>', 'javascript:void(0)', [
                                            'title' => \Yii::t('yii', 'Add validator'),
                                            'data-url' => $url,
                                            'class' => 'add-validator-btn',
                                        ]);
                                    },
                                    'edit' => function ($url, $model, $key) use ($pocket_id) {
                                        $url = Url::toRoute(['/quest/part-task/'.$model->info->getItemType(), 'id' => $pocket_id, 'item_id' => $model->id]);
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                            'title' => \Yii::t('yii', 'Edit'),
                                        ]);
                                    }
                                ]
                            ],
                        ],
                    ]); ?>
                <?php endforeach; ?>
            <?php else: ?>
                Нет заданий...
            <?php endif ?>
        </div>
        <div class="ibox-footer">
            <?= Html::a('Создать список',
                ['/quest/pocket-part/task', 'id' => $model->id],
                ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<script>
    $('.choose-validator').ladda();
    $('#validator-add-btn').ladda();
    $(function(){
        $(document.body).on('click', '.choose-validator', function(){
            var $self = $(this);
            $self.ladda( 'start' );

            var triggers = {
                'success'   : 'part:view:validator:form:success',
                'complete'  : 'part:view:validator:form:complete'
            };
            $ajax.json($self.data('url'),{},'get',triggers);
        });
        $(window).on('part:view:validator:form:success', function(e, response) {
            $('[data-js="validator-modal-content"]').html(response.content);
            $('#validator-modal').modal('show');
        });
        $(window).on('part:view:validator:form:complete', function() {
            $('.choose-validator').ladda( 'stop' );
        });

        $(document.body).on('click', '.show-validator-btn', function(){
            var $self = $(this);

            var triggers = {
                'success'   : 'task:validator:show:success'
            };
            $ajax.json($self.data('url'),{},'get',triggers);
        });
        $(window).on('task:validator:show:success', function(e, response) {
            swal({
                type: 'info',
                title: 'Просмотр валидаторов',
                text: response.form,
                html: true,
                showConfirmButton: true,
                showCancelButton: false
            });
        });

        $(document.body).on('click', '.add-validator-btn', function(){
            var $self = $(this);

            var triggers = {
                'success'   : 'task:validator:form:success'
            };
            $ajax.json($self.data('url'),{},'get',triggers);

        });
        $(window).on('task:validator:form:success', function(e, response) {
            swal({
                type: 'info',
                title: 'Выберите валидатор',
                text: response.form,
                html: true,
                showConfirmButton: false,
                showCancelButton: true
            });
        });

        $(document.body).on('click', '#validator-add-btn', function(e){
            e.preventDefault();
            var $self = $(this);
            $self.ladda( 'start' );

            var $form = $self.closest('.modal-dialog').find('form');
            var data = _prepareFormData($form.find('.field').serializeArray());
            var triggers = {
                'success'   : 'part:view:validator:add:success',
                'complete'  : 'part:view:validator:add:complete'
            };

            $ajax.json($form.prop('action'),data,'post',triggers);
        });

        $(window).on('part:view:validator:add:success', function(e, response) {
            $('#validator-modal').modal('hide');
            $.pjax.reload({container: '#validator-list-'+response.validator_id});
        });
        $(window).on('part:view:validator:add:complete', function() {
            $('#validator-add-btn').ladda( 'stop' );
        });
    });
</script>