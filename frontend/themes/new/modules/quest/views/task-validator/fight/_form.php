<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\validator\QuestValidatorItemTask */
/* @var $item \common\models\validatorItem\FightValidator */
/* @var $backLink string */

\frontend\assets\plugins\SwitcheryAsset::register($this);
\frontend\assets\plugins\TouchspinAsset::register($this);
\frontend\assets\plugins\Select2Asset::register($this);
?>
<div class="quest-part-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-pocket',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'enableClientScript' => false,
        'validateOnSubmit' => false,
    ]); ?>

    <?= $form->field($item, 'type')->textInput(['class' => 'form-control']) ?>

    <?= $form->field($item, 'comment')->textInput(['class' => 'form-control']) ?>

    <?= $form->field($item, 'enemies')->textInput(['placeholder' => 'Опоненты через запятую']) ?>

    <?= $form->field($item, 'helpers')->textInput(['placeholder' => 'Помощники через запятую']) ?>

    <?= $form->field($item, 'min_damage')->textInput(['class' => 'form-control touchspin1']) ?>

    <?= $form->field($item, 'need_win')->checkbox(['class' => 'js-switch_2']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', $backLink, ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function() {
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999,
            boostat: 5,
            maxboostedstep: 10
        });

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch_2'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });
    });
</script>