<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
\frontend\assets\plugins\TouchspinAsset::register($this);



/**
 * Created by PhpStorm.
 * User: me
 * Date: 05.06.17
 * Time: 13:56
 */ ?>

<style>
    form {
        width: 700px;
        margin: 0 auto;
    }
</style>

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

	<?= $form->field($model, 'ratio_damage_tank')->textInput(['maxlength' => true, 'class' => 'form-control touchspin1', 'data-postfix' => '%']) ?>
	<?= $form->field($model, 'ratio_damage_krit')->textInput(['maxlength' => true, 'class' => 'form-control touchspin1', 'data-postfix' => '%']) ?>
	<?= $form->field($model, 'ratio_damage_uvorot')->textInput(['maxlength' => true, 'class' => 'form-control touchspin1', 'data-postfix' => '%']) ?>
	<?= $form->field($model, 'ratio_damage_unk')->textInput(['maxlength' => true, 'class' => 'form-control touchspin1', 'data-postfix' => '%']) ?>

	<div class="form-group" style="text-align: center;">
		<?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999
        });
    });
</script>