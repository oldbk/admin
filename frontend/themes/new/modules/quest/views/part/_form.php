<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\QuestPart;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\QuestPart */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $quest \common\models\Quest */

\frontend\assets\plugins\SwitcheryAsset::register($this);
\frontend\assets\plugins\DateRatePickerAsset::register($this);
\frontend\assets\plugins\TouchspinAsset::register($this);
//\frontend\assets\plugins\SummerNoteAsset::register($this);
\frontend\assets\plugins\CKEditorAsset::register($this);
?>
<style>
    .note-editor {
        border: 1px solid #e5e6e7;
        min-height: 150px;
    }
    .field-questpart-reload_to {
        display: none;
    }
</style>

<div class="quest-part-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-part',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'enableClientScript' => false,
        'validateOnSubmit' => false,
        'fieldConfig' => [
            'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>"
        ]
    ]); ?>

    <div class="summary">
        <?= $form->errorSummary($model); ?>
    </div>

    <?= $form->field($model, 'quest_id')->textInput(['disabled' => true, 'value' => $quest->name]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description_type')->dropDownList($model->getDescriptionTypes()) ?>

    <?= $form->field($model, 'description')->textarea(['class' => 'summernote']) ?>

    <?= $form->field($model, 'chat_start')->textarea(['class' => 'summernote']) ?>

    <?= $form->field($model, 'chat_end')->textarea(['class' => 'summernote']) ?>

    <?= $form->field($model, 'is_auto_finish')->checkbox(['class' => 'js-switch']) ?>
    <?= $form->field($model, 'is_auto_start')->checkbox(['class' => 'js-switch']) ?>

    <?= $form->field($model, 'part_number')->textInput(['class' => 'form-control touchspin1']) ?>

    <?= $form->field($model, 'weight')->textInput(['class' => 'form-control touchspin1']) ?>

    <?= $form->field($model, 'complete_condition_message')->textarea(['class' => 'summernote']) ?>


    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/quest/quest/view', 'id' => $quest->id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });

        elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch_2'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });

        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999
        });

        /*$('.summernote').summernote({
            height: 150,
            minHeight: 150
        });*/
        CKEDITOR.replace( 'questpart-description', {
            'enterMode' :  CKEDITOR.ENTER_BR,
            'autoParagraph' : false,
        } );
        CKEDITOR.replace( 'questpart-chat_end', {
            'enterMode' :  CKEDITOR.ENTER_BR,
            'autoParagraph' : false,
        } );
        CKEDITOR.replace( 'questpart-chat_start', {
            'enterMode' :  CKEDITOR.ENTER_BR,
            'autoParagraph' : false,
        } );

        $('.js-switch_2').on('change', function(){
            if($(this).prop('checked')) {
                $('.field-questpart-reload_to').show();
            } else {
                $('.field-questpart-reload_to').hide().find('input').val('');
            }
        });
    });
</script>
