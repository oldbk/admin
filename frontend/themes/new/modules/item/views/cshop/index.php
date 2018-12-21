<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\QuestCategory;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\helper\CategoryDressroomHelper as CDH;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\QuestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $notepad \common\models\Notepad */

\frontend\assets\plugins\ICheckAsset::register($this);
\frontend\assets\plugins\PeityAsset::register($this);
\frontend\assets\plugins\DatePickerAsset::register($this);
\frontend\assets\plugins\CKEditorAsset::register($this);
\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SwitcheryAsset::register($this);


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


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список квестов</h5>
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
                            'attribute' => 'dressroom',
                            'format' => 'raw',
							'filter' => [0 => 'Нет', 1 => 'Да'],
                            'value' => function($model) {
                                return $model->dressroomItem && $model->dressroomItem->is_active ?
									Html::a(
										'<span class="label label-success">Да</span>',
										['/item/cshop/dressroom', 'id' => $model->id],
										['class' => 'dressroom-item']
									) :
									Html::a(
										'<span class="label label-danger">Нет</span>',
										['/item/cshop/dressroom', 'id' => $model->id],
										['class' => 'dressroom-item']
									);

                            }
                        ],
						[
							'class' => 'yii\grid\ActionColumn',
							'headerOptions' => ['width' => '80'],
							'template' => '{view}',
							'buttons' => [
								'view' => function ($url, $model, $key) {
									return Html::a(
										'<span class="glyphicon glyphicon-eye-open"></span>',
										['/item/item/show', 'item_id' => $model->id, 'shop_id' => \common\helper\ShopHelper::TYPE_CSHOP],
										['class' => 'view-item']
									);
								},
							],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="item-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div data-js="modal-content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="dressroom-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div data-js="dressroom-modal-content" class="modal-content animated fadeIn">
			
        </div>
    </div>
</div>

<script>
    var old_text = null;
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



        $(document.body).on('click', '.view-item', function(e){
            e.preventDefault();

            var $self = $(this);
            var triggers = {
                'success'   : 'item:view:success'
            };
            $ajax.json($self.prop('href'),{},'get',triggers);
        });

        $(window).on('item:view:success', function(e, response) {
            $('[data-js="modal-content"]').html(response.content);
            $('#item-modal').modal('show');
        });

        $(document.body).on('click', '.dressroom-item', function(e){
            e.preventDefault();

            var $self = $(this);
            var triggers = {
                'success'   : 'item:dressroom:success'
            };
            $ajax.json($self.prop('href'),{},'get',triggers);
        });

        $(window).on('item:dressroom:success', function(e, response) {
            $('[data-js="dressroom-modal-content"]').html(response.content);
            $('#dressroom-modal').modal('show');
        });

    });

    function clearNotepad()
    {
        $('.save-btn, .cancel-btn').hide();
        $('.edit-btn').show();
        CKEDITOR.instances['notepad-message'].destroy();
    }
</script>