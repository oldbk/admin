<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\loto\LotoItem */
/* @var $item \common\models\itemInfo\iItemInfo */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><?= Html::encode($this->title) ?></h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('form/_'.$item->getItemType(), [
                    'model' => $model,
                    'item'  => $item
                ]) ?>
            </div>
        </div>
    </div>
</div>