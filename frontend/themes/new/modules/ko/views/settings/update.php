<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Quest */
/* @var $items array */
/* @var $main_id int */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Обновление настроек</h5>
            </div>
        </div>
    </div>
</div>

<?= $this->render('_form', ['isNewRecord' => false, 'main_id' => $main_id, 'items' => $items]) ?>