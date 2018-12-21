<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\DialogBot;

/* @var $this yii\web\View */
/* @var $model common\models\dialog\DialogPart */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
\frontend\assets\plugins\SummerNoteAsset::register($this);
\frontend\assets\plugins\TouchspinAsset::register($this);
?>
<style>
    .note-editor {
        border: 1px solid #e5e6e7;
        min-height: 150px;
    }
</style>
<div class="dialog-quest-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'fieldConfig' => [
            'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>",
            'horizontalCssClasses' => [
                'hint' => ''
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'bot_id')->dropDownList(ArrayHelper::map(DialogBot::find()->orderBy('name asc')->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'action_type')->dropDownList(\common\models\dialog\DialogPart::getActions()) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'message')->textarea(['class' => 'summernote']) ?>

    <?= $form->field($model, 'is_saved')->checkbox(['class' => 'js-switch']) ?>

    <?= $form->field($model, 'order_position')->textInput(['class' => 'form-control touchspin1']) ?>

    <div class="form-group" style="text-align: center">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/quest/part/view', 'id' => $model->item_id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function () {
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });

        $('.summernote').summernote({
            height: 150,
            minHeight: 150
        });

        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999
        });
    });
</script>
