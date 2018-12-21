<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\QuestMedal */
/* @var $form yii\widgets\ActiveForm */

\frontend\assets\plugins\TouchspinAsset::register($this);
?>

<div class="quest-medal-form">

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

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'day_count')->textInput(['class' => 'form-control touchspin1', 'data-postfix' => 'дн.']) ?>

    <div class="form-group" style="text-align: center">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/quest/medal/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function(){
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999
        });
    });
</script>