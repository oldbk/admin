<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use \common\models\questCondition\QuestConditionQuest;

/* @var $this yii\web\View */
/* @var $model \common\models\recipe\RecipeItemNeed */
/* @var $item \common\models\recipe\need\RecipeNeedVlad */
/* @var $recipe \common\models\recipe\Recipe */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\TouchspinAsset::register($this);
?>
<style>
    .note-editor {
        border: 1px solid #e5e6e7;
        min-height: 150px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Условие уровень персонажа</h5>
            </div>
            <div class="ibox-content">
                <div class="dialog-quest-form">

                    <?php $form = ActiveForm::begin([
                        'layout' => 'horizontal',
                        'enableClientValidation' => false,
                        'fieldConfig' => [
                            'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>",
                            'horizontalCssClasses' => [
                                'hint' => ''
                            ]
                        ]
                    ]); ?>

                    <?= $form->field($item, 'noj')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'topor')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'dubina')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'mech')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'fire')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'water')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'air')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'earth')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'light')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'gray')->textInput(['class' => 'form-control touchspin1']) ?>
                    <?= $form->field($item, 'dark')->textInput(['class' => 'form-control touchspin1']) ?>

                    <div class="form-group" style="text-align: center">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Вернуться', ['/recipe/recipe/view', 'id' => $recipe->id], ['class' => 'btn btn-default']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
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