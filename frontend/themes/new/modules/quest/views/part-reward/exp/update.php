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
                <h5><?= Html::encode($this->title) ?></h5>
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
<script>
    $(function(){
        <?php if($success): ?>
        toastr['success']('Вы успешно изменили данные');
        <?php endif; ?>
    });
</script>