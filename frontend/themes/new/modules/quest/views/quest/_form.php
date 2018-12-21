<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\Quest;
use yii\helpers\ArrayHelper;
use common\models\QuestCategory;

/* @var $this yii\web\View */
/* @var $model common\models\Quest */
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
    $items = ArrayHelper::map(QuestCategory::find()
        ->orderBy('name asc')
        ->all(), 'id', 'name');
    ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::merge(['' => 'Выберите категорию...'], $items)) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_enabled')->checkbox(['class' => 'js-switch']) ?>
    <?= $form->field($model, 'is_canceled')->checkbox(['class' => 'js-switch']) ?>

    <div class="form-group">
        <label class="control-label col-sm-3" for="lotoitem-cost"></label>
        <div class="col-sm-6">
            <div class="col-sm-2 level" style="margin-right: 5px;">
                Мин уровень <?= $form->field($model, 'min_level', ['template' => "{input}\n{error}"])
                    ->textInput(['class' => 'form-control touchspin1'])->label(false) ?>
            </div>
            <div class="col-sm-2 level">
                Макс уровень <?= $form->field($model, 'max_level', ['template' => "{input}\n{error}"])
                    ->textInput(['class' => 'form-control touchspin1'])->label(false) ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'quest_type')->dropDownList(ArrayHelper::merge(['' => 'Выберите тип...'], Quest::getTypeList())) ?>

    <div id="quest-type-<?= Quest::TYPE_DATERANGE ?>" class="quest-type-choose" style="display: none">
        <?= $form->field($model, 'daterange')->textInput(['class' => 'form-control daterange']) ?>
    </div>

    <div id="quest-type-<?= Quest::TYPE_LIMITED ?>" class="quest-type-choose" style="display: none">
        <?= $form->field($model, 'limit_count')->textInput([
            'class' => 'form-control touchspin1',
        ])->hint('Установите 0, если лимита нет') ?>
    </div>

    <div id="quest-type-<?= Quest::TYPE_INTERVAL ?>" class="quest-type-choose" style="display: none">
        <?= $form->field($model, 'limit_interval')->textInput(['class' => 'form-control touchspin1', 'data-postfix' => 'ч.']) ?>
    </div>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/quest/quest/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        $('.daterange').daterangepicker({
            format: 'DD/MM/YYYY'
        });

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });

        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999
        });

        $(document.body).on('change', '#quest-quest_type', function(){
            selectQuestType();
        });

        selectQuestType();
    });

    function selectQuestType()
    {
        var val = $('#quest-quest_type').val();

        $('.quest-type-choose').hide();
        if($('#quest-type-'+val).length) {
            $('#quest-type-'+val).show();
        }
    }
</script>
