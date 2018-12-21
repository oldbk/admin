<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
?>
<div class="middle-box text-center animated fadeInDown">
    <h2 class="font-bold"><?= Html::encode($name) ?></h2>

    <div class="error-desc">
        <?= nl2br(Html::encode($message)) ?>
        <br>
        <a href="<?= \yii\helpers\Url::toRoute('/site/index') ?>" class="btn btn-primary m-t">Dashboard</a>
    </div>
</div>
