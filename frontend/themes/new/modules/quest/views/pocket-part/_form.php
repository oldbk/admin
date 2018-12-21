<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\questPocket\QuestPocket;

/* @var $this yii\web\View */
/* @var $model \common\models\questPocket\QuestPocket */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="quest-part-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-pocket',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'enableClientScript' => false,
        'validateOnSubmit' => false,
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'condition')->dropDownList(QuestPocket::getConditions()) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton('Создать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/quest/part/view', 'id' => $model->item_id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>