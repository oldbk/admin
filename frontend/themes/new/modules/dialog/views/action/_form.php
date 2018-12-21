<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\dialog\Dialog;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\DialogAction */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\SummerNoteAsset::register($this);
?>
<style>
    .note-editor {
        border: 1px solid #e5e6e7;
        min-height: 150px;
    }
</style>
<div class="dialog-action-form">

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

    <?= $form->field($model, 'message')->textarea(['class' => 'summernote']) ?>

    <?php
    $items = ArrayHelper::map(Dialog::find()
        ->orderBy('name asc')
        ->andWhere('global_parent_id = :global_parent_id', [':global_parent_id' => $model->global_parent_id])
        ->andWhere('id != :id', [':id' => $model->dialog_id])
        ->all(), 'id', 'name');

    foreach ($items as $id => $name) {
        $items[$id] .= ' ('.$id.')';
    }
    ?>
    <?= $form->field($model, 'next_dialog_id')->dropDownList(ArrayHelper::merge([null => 'Выход'], $items)) ?>

    <div class="form-group" style="text-align: center">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/dialog/quest/view', 'id' => $model->dialog_id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function () {
        $('.summernote').summernote({
            height: 150,
            minHeight: 150
        });
    });
</script>