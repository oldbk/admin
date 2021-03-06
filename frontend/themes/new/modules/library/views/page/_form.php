<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\oldbk\LibraryCategory;
use common\models\oldbk\LibraryPage;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryPage */
/* @var $form yii\widgets\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
\frontend\assets\plugins\TouchspinAsset::register($this);
\frontend\assets\plugins\CKEditorAsset::register($this);
?>

<div class="library-page-form">

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
    $items = ArrayHelper::map(LibraryCategory::find()
        ->orderBy('title asc')
        ->all(), 'id', 'title');
    ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::merge(['' => 'Выберите категорию...'], $items)) ?>

    <?= $form->field($model, 'dir')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'page_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->dropDownList(LibraryPage::getTypeList()) ?>

    <?= $form->field($model, 'var_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'var_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_enabled')->checkbox(['class' => 'js-switch']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/library/page/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function(){
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });

        CKEDITOR.replace( 'librarypage-body', {
            'enterMode' :  CKEDITOR.ENTER_BR,
            'autoParagraph' : false,
        } );
    });
</script>