<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\Quest;
use yii\helpers\ArrayHelper;
use common\models\QuestCategory;

/* @var $this yii\web\View */
/* @var $model common\models\recipe\Recipe */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
\frontend\assets\plugins\DateRatePickerAsset::register($this);
\frontend\assets\plugins\TouchspinAsset::register($this);

?>
<style>
    .level {
        width: 200px;
    }
    .help-block {
        font-style: italic;
    }
</style>
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

    <?php

    $naems = ArrayHelper::map(\common\models\oldbk\NaemProto::find()
        ->orderBy('id DESC')
        ->all(), 'id', 'login');


    $items = ArrayHelper::map(\common\models\oldbk\CraftLocations::find()
        ->orderBy('name asc')
        ->all(), 'id', 'name');
    ?>
    <?= $form->field($model, 'location_id')->dropDownList(ArrayHelper::merge(['' => 'Выберите локацию...'], $items)) ?>

    <?php
    $items = \common\models\oldbk\CraftRazdel::find()->orderBy('razdel asc')->all();
    $razdelList = [];
    foreach ($items as $_item) {
        $razdelList[$_item->id] = $_item->rname. ' ('.$_item->razdel.')';
    }
    ?>
    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::merge(['' => 'Выберите категорию...'], $razdelList)) ?>

    <?php
    $items = ArrayHelper::map(\common\models\oldbk\CraftProf::find()
        ->orderBy('rname asc')
        ->all(), 'id', 'rname');
    ?>
    <?= $form->field($model, 'profession_id')->dropDownList(ArrayHelper::merge(['' => 'Выберите профессию...'], $items),$model->isNewRecord ? ['options' => [15 => ['selected' => 'selected']]] : []) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'difficult')->textInput(['class' => 'form-control touchspin1']) ?>

    <?= $form->field($model, 'craftmfchance')->textInput(['class' => 'form-control touchspin1', 'data-postfix' => '%']) ?>

    <?= $form->field($model, 'time')->textInput(['class' => 'form-control touchspin1', 'data-postfix' => 'мин.']) ?>

    <?= $form->field($model, 'is_vaza')->checkbox(['class' => 'js-switch']) ?>

    <?= $form->field($model, 'goden')->textInput(['class' => 'form-control touchspin1']) ?>

    <?= $form->field($model, 'notsell')->checkbox(['class' => 'js-switch']) ?>

    <?= $form->field($model, 'sowner')->checkbox(['class' => 'js-switch']) ?>

    <?= $form->field($model, 'unik')->textInput(['class' => 'form-control touchspin1']) ?>

    <?= $form->field($model, 'is_present')->checkbox(['class' => 'js-switch']) ?>
        <div style="display: none" id="is-present-option">
            <?= $form->field($model, 'present')->textInput(['class' => 'form-control']) ?>
        </div>

    <?= $form->field($model, 'naem')->dropDownList(ArrayHelper::merge([0 => 'Выбрать наёмника...'], $naems)) ?>

    <?= $form->field($model, 'is_enabled')->checkbox(['class' => 'js-switch']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', [$model->isNewRecord ? '/recipe/recipe/index' : '/recipe/recipe/view','id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });

        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999
        });

	if($('#recipe-is_present').is(':checked')) {
            $('#is-present-option').show();
        }

        $('#recipe-is_present').on('change', function(){
            if($(this).prop('checked')) {
                $('#is-present-option').show();
            } else {
                $('#recipe-present').val('');
                $('#is-present-option').hide();
            }
        });
    });
</script>
