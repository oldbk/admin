<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/**
 * Created by PhpStorm.
 * User: me
 * Date: 28.08.16
 * Time: 17:04
 *
 * @var $model \common\models\oldbk\Variables
 */

?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Время</h5>
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

                    <?php $model->value = (new DateTime())->setTimestamp($model->value)->format('Y-m-d H:i:s') ?>
                    <?= $form->field($model, 'value')->textInput(['class' => 'form-control datetime']) ?>

                    <div class="form-group" style="text-align: center">
                        <?= Html::submitButton('Изменить', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Закрыть', 'javascript:void(0)', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>