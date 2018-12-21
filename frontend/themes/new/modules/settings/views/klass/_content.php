<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/**
 * Created by PhpStorm.
 * User: me
 * Date: 05.06.17
 * Time: 13:56
 */ ?>


<div class="panel-body">

	<?php $form = ActiveForm::begin([
		'layout' => 'horizontal',
		'enableClientValidation' => false,
		'fieldConfig' => [
			'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>",
			"template" => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			'horizontalCssClasses' => [
				'hint' => ''
			]
		]
	]); ?>
	<div class="summary">
		<?= $form->errorSummary($model); ?>
	</div>

    <fieldset>
        <legend>Уворот</legend>
		<?= $form->field($model, 'klass_ratio_uv_krit')->textInput(['maxlength' => true]) ?>
    </fieldset>
    <fieldset>
        <legend>Крит</legend>
		<?= $form->field($model, 'klass_ratio_krit_uv')->textInput(['maxlength' => true]) ?>
    </fieldset>
    <fieldset>
        <legend>Танк</legend>
		<?= $form->field($model, 'klass_ratio_tank_krit')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'klass_ratio_tank_uv')->textInput(['maxlength' => true]) ?>
    </fieldset>

	<div class="form-group" style="text-align: center;">
		<?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
