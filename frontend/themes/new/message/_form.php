<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\oldbk\StaticMessage;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\StaticMessage */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\TouchspinAsset::register($this);
\frontend\assets\plugins\DateTimePickerAsset::register($this);
?>

<div class="quest-part-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-pocket',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'enableClientScript' => false,
        'validateOnSubmit' => false,
    ]); ?>

    <?= $form->field($model, 'message_type')->dropDownList(StaticMessage::getTypeList()) ?>

    <?= $form->field($model, 'message')->textarea() ?>

    <?php if(!$model->is_fixed): ?>
    <?= $form->field($model, 'day_interval')->textInput(['class' => 'form-control touchspin1', 'data-postfix' => 'дн.']) ?>

    <?php
    $datetime = null;
    if($model->must_send > 0) {
        $datetime = Yii::$app->formatter->asDate($model->must_send, 'dd/MM/YYYY HH:mm');
    }
    $model->must_send = $datetime;
    ?>
    <?= $form->field($model, 'must_send')->textInput(['class' => 'form-control datetime']) ?>
    <?php endif; ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton('Создать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', Yii::$app->request->getReferrer(), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        $('.datetime').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        });

        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999,
            boostat: 5,
            maxboostedstep: 10
        });
    });
</script>