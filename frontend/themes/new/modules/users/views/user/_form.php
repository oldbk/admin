<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
?>
<style>
    #change-password {
        display: none;
    }
</style>
<div class="user-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'fieldConfig' => [
            'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>"
        ]
    ]); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(User::getStatusList()) ?>
    <?= $form->field($model, 'short_description')->textInput() ?>


    <?php if(!$model->isNewRecord): ?>
        <?= $form->field($model, 'change_password')->checkbox(['class' => 'js-switch']) ?>
    <?php endif; ?>

    <div id="change-password">
        <?= $form->field($model, 'password')->passwordInput(['value' => '']) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(['value' => '']) ?>
    </div>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/users/user/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        <?php if($model->isNewRecord): ?>
            $('#change-password').show();
        <?php endif; ?>
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });

        $('.js-switch').on('change', function(){
            if($(this).prop('checked')) {
                $('#change-password').show();
            } else {
                $('#change-password').hide().find('input').val('');
            }
        });
    });
</script>