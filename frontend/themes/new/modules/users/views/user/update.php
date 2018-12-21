<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Пользователь: <?= Html::encode($model->username) ?></h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>