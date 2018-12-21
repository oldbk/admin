<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use \common\models\questCondition\QuestConditionQuest;

/* @var $this yii\web\View */
/* @var $model common\models\dialog\DialogQuest */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $return_url string */
\frontend\assets\plugins\TouchspinAsset::register($this);
\frontend\assets\plugins\DateTimePickerAsset::register($this);
\frontend\assets\plugins\SwitcheryAsset::register($this);
?>
<style>
    .note-editor {
        border: 1px solid #e5e6e7;
        min-height: 150px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Условие лимит по кол-ву выполнений</h5>
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

					<?php /*$form->field($model, 'current_week')->checkbox(['class' => 'js-switch']);*/ ?>
                    <div id="date-wrap">
						<?= $form->field($model, 'date_start')->textInput(['class' => 'form-control datetime']) ?>
						<?= $form->field($model, 'date_end')->textInput(['class' => 'form-control datetime']) ?>
                    </div>

                    <?= $form->field($model, 'count')->textInput(['class' => 'form-control touchspin1']) ?>

                    <div class="form-group" style="text-align: center">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Вернуться', $return_url, ['class' => 'btn btn-default']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999
        });

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });

        $('.datetime').datetimepicker({
            format: 'DD.MM.YYYY'
        });

        if(!$('#questconditioncount-current_week').is(':checked')) {
            $('#date-wrap').show();
        } else {
            $('#date-wrap').hide();
            $('#iquestconditioncount-date_start').val('');
            $('#iquestconditioncount-date_end').val('');
        }

        $('#questconditioncount-current_week').on('change', function(){
            if(!$(this).prop('checked')) {
                $('#date-wrap').show();
            } else {
                $('#iquestconditioncount-date_start').val('');
                $('#iquestconditioncount-date_end').val('');
                $('#date-wrap').hide();
            }
        });
    });
</script>