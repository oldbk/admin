<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\models\questTask\EventTask;

/* @var $this yii\web\View */
/* @var $model \common\models\QuestPocketItem */
/* @var $item \common\models\questTask\KillBotTask */

\frontend\assets\plugins\TouchspinAsset::register($this);
\frontend\assets\plugins\Select2Asset::register($this);
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

    <div class="summary">
        <?= $form->errorSummary($model); ?>
    </div>

    <?= $form->field($item, 'bot_names')->textInput(['placeholder' => 'Имена ботов через запятую']) ?>
    <?= $form->field($item, 'diff_bot')->checkbox(['class' => 'js-switch_2']) ?>

    <?= $form->field($model, 'count')->textInput(['class' => 'form-control touchspin1']) ?>
	<?= $form->field($item, 'start_count')->textInput(['class' => 'form-control touchspin1']) ?>
	<?= $form->field($item, 'can_be_multiple')->checkbox(['class' => 'js-switch_2']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/quest/part/view', 'id' => $model->pocket_item_id], ['class' => 'btn btn-default']) ?>
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