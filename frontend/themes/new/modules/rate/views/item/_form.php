<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\QuestPart;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\TopList */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['class' => 'summernote']) ?>

    <?= $form->field($model, 'description2')->textarea(['class' => 'summernote']) ?>

    <?= $form->field($model, 'is_enabled')->checkbox(['class' => 'js-switch']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/rate/item/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });

        CKEDITOR.replace( 'toplist-description' );
        CKEDITOR.replace( 'toplist-description2' );
    });
</script>
