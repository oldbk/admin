<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\RateManager;

/* @var $this yii\web\View */
/* @var $model common\models\RateManager */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\TouchspinAsset::register($this);
\frontend\assets\plugins\SwitcheryAsset::register($this);
?>
<div class="quest-list-form">

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

    <?= $form->field($model, 'rate_key')->dropDownList(ArrayHelper::merge(['' => 'Выберите рейтинг...'], RateManager::getRateKeys())) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'description')->textarea() ?>
	<?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'link_encicl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_enabled')->checkbox(['class' => 'js-switch']) ?>

	<?= $form->field($model, 'iteration')->dropDownList(ArrayHelper::merge(['' => 'Выберите тип...'], RateManager::getRateIteration())) ?>
	<?= $form->field($model, 'reward_till_days')->textInput(['class' => 'form-control touchspin1']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/rate/manager/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function () {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });

        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999
        });
    });
</script>