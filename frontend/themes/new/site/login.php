<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">IN+</h1>

        </div>
        <h3>Welcome to IN+</h3>
        <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
            <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
        </p>
        <p>Login in. To see it in action.</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'm-t', 'role' => 'form']]); ?>
            <div class="form-group">
                <?= $form->field($model, 'username')->textInput([
                    'autofocus' => true,
                    'class' => 'form-control',
                    'placeholder' => 'Username',
                    'required' => '',
                ]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'password')->passwordInput([
                    'class' => 'form-control',
                    'placeholder' => 'Password',
                    'required' => '',
                ]) ?>
            </div>
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>

            <a href="#"><small>Forgot password?</small></a>
        <?php ActiveForm::end(); ?>
    </div>
</div>