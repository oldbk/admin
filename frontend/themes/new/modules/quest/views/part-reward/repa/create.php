<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \common\models\QuestPocketItem */
/* @var $pocket \common\models\questPocket\QuestPocketPartReward */
/* @var $item \common\models\itemInfo\iItemInfo */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Добавление репутации для награды к часте "<?= $pocket->part->name ?>"</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                    'item'  => $item,
                    'pocket' => $pocket
                ]) ?>
            </div>
        </div>
    </div>
</div>