<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\QuestPart */
/* @var $quest common\models\Quest */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Добавление части к <?= $quest->name ?></h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                    'quest' => $quest,
                ]) ?>
            </div>
        </div>
    </div>
</div>