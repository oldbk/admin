<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\pool\PoolPocket;

/* @var $this yii\web\View */
/* @var $model common\models\pool\PoolPocket */
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

    <?= $form->field($model, 'description')->textarea() ?>
	<?= $form->field($model, 'condition')->dropDownList(PoolPocket::getConditions()) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', Yii::$app->request->getReferrer(), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>