<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\oldbk\LibraryCategory;


/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryCategory */
/* @var $form yii\widgets\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
?>

<div class="library-category-form">

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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
    $items = ArrayHelper::map(LibraryCategory::find()
        ->orderBy('id asc')
        ->all(), 'id', 'title');
    ?>

    <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::merge(['-1' => 'Без родительской категории'], $items)) ?>


    <?= $form->field($model, 'is_enabled')->checkbox(['class' => 'js-switch']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/library/category/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function(){
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });
    });
</script>