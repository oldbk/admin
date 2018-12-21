<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\search\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'topic') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'parent') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'print_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
