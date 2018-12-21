<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quest-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'started_at') ?>

    <?= $form->field($model, 'ended_at') ?>

    <?= $form->field($model, 'is_enabled') ?>

    <?php // echo $form->field($model, 'min_level') ?>

    <?php // echo $form->field($model, 'part_count') ?>

    <?php // echo $form->field($model, 'count_do') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
