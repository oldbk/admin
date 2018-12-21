<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\QuestPocketItem */
/* @var $item \common\models\questTask\iQuestTask */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Добавление использование магии в задание</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                    'item'  => $item
                ]) ?>
            </div>
        </div>
    </div>
</div>