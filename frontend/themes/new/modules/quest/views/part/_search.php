<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\QuestPartSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quest-part-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'quest_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description_data') ?>

    <?= $form->field($model, 'part_gift') ?>

    <?php // echo $form->field($model, 'chat_start') ?>

    <?php // echo $form->field($model, 'chat_end') ?>

    <?php // echo $form->field($model, 'is_auto_finish') ?>

    <?php // echo $form->field($model, 'part_number') ?>

    <?php // echo $form->field($model, 'get_validators') ?>

    <?php // echo $form->field($model, 'can_reload') ?>

    <?php // echo $form->field($model, 'reload_to') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
