<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $model \common\models\questPocket\QuestPocket */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Привязка диалога</h5>
            </div>
            <div class="ibox-content">
                <div class="quest-part-form">

                    <?php $form = ActiveForm::begin([
                        'id' => 'form-pocket',
                        'layout' => 'horizontal',
                        'enableClientValidation' => false,
                        'enableClientScript' => false,
                        'validateOnSubmit' => false,
                    ]); ?>

                    <?= $form->field($model, 'dialog_finish_id')->dropDownList(ArrayHelper::map(Dialog::find()
                        ->andWhere('global_parent_id = :global_parent_id', [':global_parent_id' => $model->part->quest_id])->orderBy('name asc')->all(), 'id', 'name')) ?>

                    <div class="form-group" style="text-align: center;">
                        <?= Html::submitButton('Создать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        <?= Html::a('Вернуться', ['/quest/part/view', 'id' => $model->item_id], ['class' => 'btn btn-default']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>