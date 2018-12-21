<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\validator\QuestValidatorItemTask */
/* @var $item \common\models\validatorItem\UserValidator */
/* @var $backLink string */

?>
<div class="quest-part-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-pocket',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'enableClientScript' => false,
        'validateOnSubmit' => false,
    ]); ?>

    <?= $form->field($item, 'gender')->dropDownList(ArrayHelper::merge(['' => 'Любой'], \common\models\User::getGenders())) ?>

    <?= $form->field($item, 'level')->textInput(['class' => 'form-control']) ?>

    <?= $form->field($item, 'align')->textInput() ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', $backLink, ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>