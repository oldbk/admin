<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\QuestCategory;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\QuestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $notepad \common\models\Notepad */

\frontend\assets\plugins\ICheckAsset::register($this);
\frontend\assets\plugins\PeityAsset::register($this);
\frontend\assets\plugins\DatePickerAsset::register($this);
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
	<?= Html::a('Создать акцию', ['create'], ['class' => 'btn btn-success']) ?>
	<?= Html::a('Очистить кэш', 'javascript:void(0)', [
		'class' => 'btn btn-primary ladda-button',
		'id' => 'clear-cache-btn',
		'data-url' => Url::to(['/ko/config/cache']),
		'data-style' => 'expand-left',
	]) ?>
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
							'attribute' => 'title'
						],
						[
							'attribute' => 'is_enabled',
							'format' => 'raw',
							'value' => function($model){
								return $model->is_enabled ? '<span class="label label-success">Да</span>'
									: '<span class="label label-danger">Нет</span>';
							}
						],
						[
							'class' => 'yii\grid\ActionColumn',
							'headerOptions' => ['width' => '80'],
							'template' => '{view} {update}',
							'buttons' => [

							],
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
    $(function(){
        $('.save-btn').ladda();

        $(document.body).on('click', '#clear-cache-btn', function(){
            var $self = $(this);

            swal({
                title: "Вы уверены?",
                text: 'Запустить процесс очистки кэша КО?',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, запустить процесс!",
                closeOnConfirm: false,
                cancelButtonText: 'Отмена',
                showLoaderOnConfirm: true
            }, function () {
                var triggers = {
                    'success'   : 'cache:clear:success',
                    'error'     : 'cache:clear:complete'
                };
                $ajax.json($self.data('url'),{},'get',triggers);
            });
        });
        $(window).on('cache:clear:success', function(e, response) {
            swal("Готово!", "Процесс успешно завершен.", "success");
        });
        $(window).on('cache:clear:error', function() {
            swal.close();
        });

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

        $("#quest-grid").on("pjax:end", function() {
            events();
        });
        events();
    });

    function clearNotepad()
    {
        $('.save-btn, .cancel-btn').hide();
        $('.edit-btn').show();
        CKEDITOR.instances['notepad-message'].destroy();
    }

    function events()
    {
        $('.datetime input').datepicker({
            startView: 1,
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd-mm-yyyy"
        });
    }
</script>