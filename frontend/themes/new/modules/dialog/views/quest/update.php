<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\dialog\DialogQuest */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Обновление диалога. Квест <?= $quest->name; ?></h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
