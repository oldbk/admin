<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \common\models\pool\PoolPocketItem */
/* @var $pocket \common\models\pool\PoolPocket */
/* @var $item \common\models\itemInfo\iItemInfo */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Добавление опыта для награды к пулу "<?= $pocket->pool->name ?>"</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>