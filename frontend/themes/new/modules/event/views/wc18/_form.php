<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\QuestPart;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\event\EventWc */
/* @var $form yii\bootstrap\ActiveForm */

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

	<?= $form->field($model, 'team1_id')->dropDownList(ArrayHelper::map(\common\models\event\EventWcTeam::find()->orderBy('name asc')->all(), 'id', 'name')) ?>
	<?= $form->field($model, 'team2_id')->dropDownList(ArrayHelper::map(\common\models\event\EventWcTeam::find()->orderBy('name asc')->all(), 'id', 'name')) ?>

    <?php
    $datetime = null;
    if($datetime > 0) {
		$datetime = (new DateTime())->setTimestamp($model->datetime)->format('Y-m-d H:i:s');
    }
    ?>
    <?= $form->field($model, 'datetime')->textInput(['maxlength' => true, 'class' => 'datetime form-control', 'value' => $datetime]) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', Yii::$app->request->getReferrer(), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        $('.datetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        });
    });
</script>