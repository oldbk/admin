<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/**
 * Created by PhpStorm.
 * User: me
 * Date: 28.08.16
 * Time: 17:04
 *
 * @var $model \common\models\event\EventWc
 */

?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Задать результат для <?= sprintf('%s - %s', $model->team1->name, $model->team2->name) ?></h5>
            </div>
            <div class="ibox-content">
                <div class="dialog-quest-form">

                    <?php $form = ActiveForm::begin([
                        'id' => 'form-wc-change',
                        'layout' => 'horizontal',
                        'enableClientValidation' => false,
                        'fieldConfig' => [
                            'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>",
                            'horizontalCssClasses' => [
                                'hint' => ''
                            ]
                        ],
                    ]); ?>

                    <?= $form->field($model, 'team1_res')->textInput([]) ?>
                    <?= $form->field($model, 'team2_res')->textInput([]) ?>
					<?= $form->field($model, 'who_win')->dropDownList(\common\models\event\EventWc::getWinLabel()) ?>

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