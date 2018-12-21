<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Quest */
/* @var $group_id int */
/* @var $main_id int */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Добавление настроек</h5>
            </div>
        </div>
    </div>
</div>

<?= $this->render('_form', ['isNewRecord' => true, 'main_id' => $main_id, 'items' => []]) ?>