<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\search\WordfilterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forumcleaner-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'a_info')->textInput() ?>
    <?= $form->field($model, 'text')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
