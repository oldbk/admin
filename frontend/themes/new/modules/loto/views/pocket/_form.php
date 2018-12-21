<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\QuestPart;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\loto\LotoPocket */
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

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton('Создать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', Yii::$app->request->getReferrer(), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>