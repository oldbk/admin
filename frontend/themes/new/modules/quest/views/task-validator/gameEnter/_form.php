<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\validatorItem\LocationValidator;

/* @var $this yii\web\View */
/* @var $model common\models\validator\QuestValidatorItemTask */
/* @var $item \common\models\validatorItem\FightValidator */
/* @var $backLink string */

\frontend\assets\plugins\SwitcheryAsset::register($this);

?>
<div class="quest-part-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-pocket',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'enableClientScript' => false,
        'validateOnSubmit' => false,
    ]); ?>

    <?= $form->field($item, 'first_all')->checkbox(['class' => 'js-switch_2']) ?>
    <?= $form->field($item, 'first_day')->checkbox(['class' => 'js-switch_2']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', $backLink, ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
    $(function() {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch_2'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });
    });
</script>