<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\event\EventWc */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><?= Html::encode($this->title) ?></h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>