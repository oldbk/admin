<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RateManagerCondition */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $rate_id integer */

\frontend\assets\plugins\DateTimePickerAsset::register($this);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Условие по диапазону дат</h5>
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

                    <div id="date-wrap">
						<?= $form->field($model, 'date_start')->textInput(['class' => 'form-control datetime']) ?>
						<?= $form->field($model, 'date_end')->textInput(['class' => 'form-control datetime']) ?>
                    </div>

                    <div class="form-group" style="text-align: center">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
						<?= Html::a('Вернуться', ['/rate/manager/view', 'id' => $rate_id], ['class' => 'btn btn-default']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.datetime').datetimepicker({
            format: 'DD.MM.YYYY'
        });
    });
</script>