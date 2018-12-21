<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\pool\Pool;

/* @var $this yii\web\View */
/* @var $model common\models\pool\PoolAssign */
/* @var $settings common\models\pool\PoolAssignRating */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\TouchspinAsset::register($this);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Привязать пул к рейтингу <?= $model->target_name ?></h5>
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

					<?php
					$items = ArrayHelper::map(Pool::find()
						->orderBy('name asc')
						->all(), 'id', 'name');
					?>

					<?= $form->field($model, 'pool_id')->dropDownList(ArrayHelper::merge(['' => 'Выберите пул...'], $items)) ?>
					<?= $form->field($settings, 'min_position')->textInput(['class' => 'form-control touchspin1']) ?>
					<?= $form->field($settings, 'max_position')->textInput(['class' => 'form-control touchspin1']) ?>

                    <div class="form-group" style="text-align: center">
                        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Вернуться', ['/rate/manager/view', 'id' => $model->target_id], ['class' => 'btn btn-default']) ?>
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