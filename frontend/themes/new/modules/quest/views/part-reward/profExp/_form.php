<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\helper\CurrencyHelper;

/* @var $this yii\web\View */
/* @var $model \common\models\QuestPocketItem */
/* @var $item common\models\itemInfo\ProfExpInfo */
/* @var $form yii\bootstrap\ActiveForm */

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

    <?php $items = \yii\helpers\ArrayHelper::map(\common\models\oldbk\CraftProf::find()
        ->orderBy('rname asc')
        ->all(), 'id', 'rname');
    ?>
    <?= $form->field($item, 'profession_id')->dropDownList($items) ?>

    <?= $form->field($model, 'count')->textInput(['class' => 'form-control touchspin1']) ?>

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