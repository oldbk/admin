<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \frontend\models\export\Email;

/**
 * Created by PhpStorm.
 * User: me
 * Date: 11.06.17
 * Time: 16:01
 *
 * @var \frontend\models\export\Email $model
 */
?>

<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Экспорт email-ов</h5>
			</div>
			<div class="ibox-content">
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

				<?= $form->field($model, 'last_enter')->dropDownList(Email::getList()) ?>
				<?php
				$items = [];
				for($i = 1; $i < 15; $i++) {
					$items[$i] = $i.' и выше';
				}
				?>
				<?= $form->field($model, 'level')->dropDownList($items) ?>

				<div class="form-group" style="text-align: center;">
					<?= Html::submitButton('Экспортировать', ['class' => 'btn btn-primary']) ?>
				</div>

				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
