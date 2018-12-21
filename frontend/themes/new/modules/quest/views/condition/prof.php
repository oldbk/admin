<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use \common\models\questCondition\QuestConditionQuest;

/* @var $this yii\web\View */
/* @var $model common\models\dialog\DialogQuest */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $return_url string */

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
                <h5>Условие квест</h5>
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

                    <?= $form->field($model, 'profession_id')->dropDownList(ArrayHelper::map(\common\models\oldbk\CraftProf::find()->orderBy('rname asc')->all(), 'id', 'rname')) ?>

                    <?= $form->field($model, 'level')->textInput(['class' => 'form-control touchspin1']) ?>

                    <div class="form-group" style="text-align: center">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Вернуться', $return_url, ['class' => 'btn btn-default']) ?>
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
