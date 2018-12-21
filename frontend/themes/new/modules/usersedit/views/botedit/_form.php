<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\oldbk\Users;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryPage */
/* @var $form yii\widgets\ActiveForm */

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

    <?= $form->field($model, 'info')->textarea(['rows' => 10]) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/usersedit/botedit/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function(){
        CKEDITOR.replace( 'users-info', {
            'enterMode' :  CKEDITOR.ENTER_BR,
            'autoParagraph' : false,
        } );
    });
</script>