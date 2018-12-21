<?php
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * Created by PhpStorm.
 * User: me
 * Date: 05.06.17
 * Time: 13:39
 *
 * @var $klass_ratio_tank_uv \common\models\oldbk\Settings
 * @var $klass_ratio_tank_krit \common\models\oldbk\Settings
 * @var $klass_ratio_krit_uv \common\models\oldbk\Settings
 * @var $klass_ratio_uv_krit \common\models\oldbk\Settings
 * @var \yii\web\View $this
 */

\frontend\assets\plugins\CKEditorAsset::register($this);
\frontend\assets\plugins\LaddaAsset::register($this);

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

<div class="tabs-container">
	<?= \yii\bootstrap\Tabs::widget([
		'items' => [
			[
				'label' => 'Базовые',
				'url' => ['/settings/default/index'],

			],
			[
				'label' => 'Классы',
				'content' => $this->render('_content', [
					'model' => $model,
				]),
				'active' => true
			],
			[
				'label' => 'Урон',
				'url' => ['/settings/damage/index'],
			],
			[
				'label' => 'Конфиг КО',
				'url' => ['/ko/config/index'],
			],
		],
	]); ?>
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
    });

    function clearNotepad()
    {
        $('.save-btn, .cancel-btn').hide();
        $('.edit-btn').show();
        CKEDITOR.instances['notepad-message'].destroy();
    }
</script>