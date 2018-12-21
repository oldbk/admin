<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\validator\QuestValidatorItemTask */
/* @var $item \common\models\validatorItem\FightValidator */
/* @var $backLink string */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Добавление валидатора боя в задание</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                    'item'  => $item,
                    'backLink' => $backLink
                ]) ?>
            </div>
        </div>
    </div>
</div>