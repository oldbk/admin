<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\helper\CurrencyHelper;
use yii\helpers\ArrayHelper;
use common\models\QuestMedal;

/* @var $this yii\web\View */
/* @var $model \common\models\QuestPocketItem */
/* @var $item common\models\itemInfo\MedalInfo */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
\frontend\assets\plugins\Select2Asset::register($this);
\frontend\assets\plugins\TouchspinAsset::register($this);
?>

<div class="loto-item-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'fieldConfig' => [
            'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>"
        ]
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($item, 'medal_id')->dropDownList(ArrayHelper::map(QuestMedal::find()->orderBy('name asc')->all(), 'id', 'name')) ?>

    <div class="form-group">
        <label class="control-label col-sm-3" for="lotoitem-cost">Стадия 1</label>
        <div class="col-sm-8">
            <div class="col-sm-4" style="margin-right: 5px;">
                <?= $form->field($item, 'medal_stage_1', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Ссылка на изображение']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($item, 'medal_stage_1_title', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Название']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="lotoitem-cost">Стадия 2</label>
        <div class="col-sm-8">
            <div class="col-sm-4" style="margin-right: 5px;">
                <?= $form->field($item, 'medal_stage_2', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Изображение']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($item, 'medal_stage_2_title', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Название']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="lotoitem-cost">Стадия 3</label>
        <div class="col-sm-8">
            <div class="col-sm-4" style="margin-right: 5px;">
                <?= $form->field($item, 'medal_stage_3', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Изображение']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($item, 'medal_stage_3_title', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Название']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="lotoitem-cost">Стадия 4</label>
        <div class="col-sm-8">
            <div class="col-sm-4" style="margin-right: 5px;">
                <?= $form->field($item, 'medal_stage_4', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Изображение']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($item, 'medal_stage_4_title', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Название']) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-3" for="lotoitem-cost">Стадия 5</label>
        <div class="col-sm-8">
            <div class="col-sm-4" style="margin-right: 5px;">
                <?= $form->field($item, 'medal_stage_5', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Изображение']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($item, 'medal_stage_5_title', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true, 'placeholder' => 'Название']) ?>
            </div>
        </div>
    </div>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/quest/part/view', 'id' => $model->pocket_item_id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999,
            boostat: 5,
            maxboostedstep: 10
        });
    });
</script>