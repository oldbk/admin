<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\Wordfilter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wordfilter-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'onlyfull')->checkbox(['label' => "Только полный поиск?"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
