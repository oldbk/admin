<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\QuestCategory;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\RecipeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $notepad \common\models\Notepad */

\frontend\assets\plugins\CKEditorAsset::register($this);
\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);


?>
<style>
    .save-btn, .cancel-btn {
        display: none;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Заметка</h5>
            </div>
            <div class="ibox-content">
                <div class="form-group">
                    <?= Html::a('Сохранить', 'javascript:void(0)', [
                        'class' => 'btn btn-primary save-btn ladda-button btn-xs',
                        'data-style' => 'expand-left'
                    ]) ?>
                    <?= Html::a('Отмена', 'javascript:void(0)', ['class' => 'btn btn-default cancel-btn btn-xs']) ?>
                    <?= Html::a('Редактировать', 'javascript:void(0)', ['class' => 'btn btn-success edit-btn btn-xs']) ?>
                </div>
                <div class="row notepad-message" id="notepad-message">
                    <?= $notepad->message; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="quest-list-index">
    <?= Html::a('Создать рецепт', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Экспортировать все', 'javascript:void(0)', [
        'class' => 'btn btn-primary ladda-button',
        'id' => 'export-btn',
        'data-url' => Url::to(['/recipe/recipe/all']),
        'data-style' => 'expand-left',
    ]) ?>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список рецептов</h5>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin(['id' => 'quest-grid']); ?>
                <?= \yii\grid\GridView::widget([
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
                            'attribute' => 'id'
                        ],
                        [
                            'attribute' => 'name'
                        ],
                        [
                            'attribute' => 'time'
                        ],
                        [
                            'attribute' => 'profession_id',
                            'value' => 'profession.rname',
                            'label' => 'Профессия',
                            'filter' => ArrayHelper::map(\common\models\oldbk\CraftProf::find()
                                ->orderBy('name asc')
                                ->all(), 'id', 'rname')
                        ],
                        [
                            'attribute' => 'category_id',
                            'value' => 'razdel.rname',
                            'label' => 'Раздел',
			    'contentOptions' => ['style' => 'width:200px;'],
                            'filter' => ArrayHelper::map(\common\models\oldbk\CraftRazdel::find()
                                ->orderBy('rname asc')
                                ->all(), 'id', 'rname')
                        ],
                        [
                            'attribute' => 'is_vaza',
                            'format' => 'raw',
                            'value' => function($model) {return $model->is_vaza ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'; }

                        ],
                        [
                            'attribute' => 'is_enabled',
                            'format' => 'raw',
                            'value' => function($model) {return $model->is_enabled ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'; }

                        ],
                        [
                            'attribute' => 'difficult'
                        ],
                        [
                            'attribute' => 'cost_need',
                        ],
                        [
                            'attribute' => 'cost_profit',
                            'value' => function($model){
                                    return $model->cost_profit - $model->cost_need. ' ('.$model->cost_profit.')';
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '80'],
                            'template' => '{view} {clone} {calc} {update} {delete}',
                            'buttons' => [
                                'clone' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<i class="fa fa-copy"></i>',
                                        ['/recipe/recipe/clone', 'id' => $model->id],
                                        ['title' => 'Клонировать']
                                    );
                                },
                                'calc' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<i class="glyphicon glyphicon-dashboard"></i>',
                                        ['/recipe/recipe/calc', 'id' => $model->id],
                                        ['title' => 'Посчитать']
                                    );
                                },
                            ]
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    var old_text = null;
    var $export_btn = $('#export-btn');
    $(function(){
        $('.save-btn').ladda();

        $(document.body).on('click', '.edit-btn', function(){
            $(this).hide();
            CKEDITOR.replace( 'notepad-message');
            CKEDITOR.instances['notepad-message'].focus();

            old_text = CKEDITOR.instances['notepad-message'].getData();
            $('.save-btn, .cancel-btn').show();
        });
        $(document.body).on('click', '.cancel-btn', function(){
            clearNotepad();
            $('#notepad-message').html(old_text);
        });
        $(document.body).on('click', '.save-btn', function(){
            var triggers = {
                'success'   : 'notepad:save:success',
                'error'     : 'notepad:save:error'
            };
            var data = {
                'message' : CKEDITOR.instances['notepad-message'].getData()
            };
            $('.save-btn').ladda( 'start' );
            $ajax.json('<?= Url::to(['/notepad/save', 'id' => $notepad->id]) ?>', data, null, triggers);
        });
        $(window).on('notepad:save:success', function(e, response) {
            $('.save-btn').ladda( 'stop' );
            clearNotepad();
        });
        $(window).on('notepad:save:error', function(e, response) {
            $('.save-btn').ladda( 'stop' );
        });

        $export_btn.ladda();

        $(document.body).on('click', '#export-btn', function(){
            var $self = $(this);

            swal({
                title: "Вы уверены?",
                text: 'Запустить процесс экспорта рецептов в игру?',
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

    function clearNotepad()
    {
        $('.save-btn, .cancel-btn').hide();
        $('.edit-btn').show();
        CKEDITOR.instances['notepad-message'].destroy();
    }
</script>
