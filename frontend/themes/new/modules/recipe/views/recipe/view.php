<?php
use yii\bootstrap\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * Created by PhpStorm.
 * User: me
 * Date: 16.09.16
 * Time: 02:01
 */

/* @var $this yii\web\View */
/* @var $model common\models\recipe\Recipe */

\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);
?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Рецепт: <?= Html::encode($model->name) ?></h5>
            </div>
            <div class="ibox-content">
                <?php $attributes  = [
                    'id',
                    [
                        'attribute' => 'location.name',
                        'label' => 'Локация',
                    ],
                    [
                        'attribute' => 'razdel.rname',
                        'label' => 'Раздел'
                    ],
                    [
                        'attribute' => 'profession.rname',
                        'label' => 'Профессия',
                    ],
                    'name',
                    'difficult',
                    'time',
                    [
                        'attribute' => 'craftmfchance',
                        'value' => $model->craftmfchance.' %',
                    ],
                    [
                        'attribute' => 'is_vaza',
                        'format' => 'raw',
                        'value' => $model->is_vaza ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
                    ],
                    [
                        'attribute' => 'goden',
                        'value' => $model->goden.' дней',
                    ],
                    [
                        'attribute' => 'notsell',
                        'format' => 'raw',
                        'value' => $model->notsell ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
                    ],
                    [
                        'attribute' => 'sowner',
                        'format' => 'raw',
                        'value' => $model->sowner ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
                    ],
                    [
                        'attribute' => 'unik',
                        'value' => $model->unik,
                    ],
                    [
                        'attribute' => 'is_present',
                        'format' => 'raw',
                        'value' => $model->is_present ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
                    ],
					[
						'attribute' => 'naemproto.login',
						'format' => 'raw',
						'value' => $model->naem ? $model->naemproto->login
							: '<span class="label label-danger">Нет</span>',
					],
                    [
                        'attribute' => 'naemproto.login',
                        'label' => 'Наёмник',
                    ],
                    [
                        'attribute' => 'is_enabled',
                        'format' => 'raw',
                        'value' => $model->is_enabled ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
                    ],
                ];

                ?>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes,
                ]) ?>

                <p>
                    <?= Html::a('Экспортировать', 'javascript:void(0)', [
                        'class' => 'btn btn-primary ladda-button',
                        'id' => 'export-btn',
                        'data-url' => Url::to(['/recipe/recipe/export', 'id' => $model->id]),
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
                    <?= Html::a('Вернуться', ['/recipe/recipe/index'], ['class' => 'btn btn-default']) ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="quest-condition-index">
    <p>
        <?= Html::a('Склонность', ['/recipe/need/align', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Уровень персонажа', ['/recipe/need/userLevel', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Профессия', ['/recipe/need/profession', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Ингредиент', ['/recipe/need/ingredient', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Статы', ['/recipe/need/stat', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Владения', ['/recipe/need/vlad', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
    </p>
</div>
<div id="quest-condition-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Условия</h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin([
                'id' => 'quest-condition-grid',
                'enablePushState' => false,
                'scrollTo' => true
            ]); ?>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $itemNeedProvider,
                'options' => [
                    'class' => 'table-responsive'
                ],
                'tableOptions' => [
                    'class' => 'table table-striped'
                ],
                'summary' => false,
                'columns' => [
                    [
                        'label' => 'Описание',
                        'format' => 'raw',
                        'value' => function($model){
                            return $model->info->getDescription();
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'controller' => '/recipe/need',
                        'buttons' => [
                            'delete' => function($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/recipe/need/delete', 'item_id' => $model->id], [
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


<div class="quest-condition-index">
    <p>
        <?= Html::a('Опыт', ['/recipe/give/exp', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Предмет', ['/recipe/give/item', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
    </p>
</div>
<div id="quest-condition-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Профит</h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin([
                'id' => 'quest-condition-grid',
                'enablePushState' => false,
                'scrollTo' => true
            ]); ?>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $itemGiveProvider,
                'options' => [
                    'class' => 'table-responsive'
                ],
                'tableOptions' => [
                    'class' => 'table table-striped'
                ],
                'summary' => false,
                'columns' => [
                    [
                        'label' => 'Описание',
                        'format' => 'raw',
                        'value' => function($model){
                            return $model->info->getDescription();
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'controller' => '/recipe/need',
                        'buttons' => [
                            'delete' => function($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/recipe/give/delete', 'item_id' => $model->id], [
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

<script>
    var $export_btn = $('#export-btn');
    $(function(){
        $export_btn.ladda();

        $(document.body).on('click', '#export-btn', function(){
            var $self = $(this);

            swal({
                title: "Вы уверены?",
                text: 'Запустить процесс экспорта рецепта в игру?',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, запустить процесс!",
                closeOnConfirm: false,
                cancelButtonText: 'Отмена',
                showLoaderOnConfirm: true
            }, function () {
                var triggers = {
                    'success'   : 'recipe:export:success',
                    'error'     : 'recipe:export:complete'
                };
                $ajax.json($self.data('url'),{},'get',triggers);
            });
        });

        $(window).on('recipe:export:success', function(e, response) {
            swal("Готово!", "Процесс успешно завершен.", "success");
        });
        $(window).on('recipe:export:error', function() {
            swal.close();
        });
    });
</script>