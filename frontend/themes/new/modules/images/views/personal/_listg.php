<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier
?>
<div class="imgshadow">
	<?= Html::checkbox('gifts[]', false,['value' => $model->id]);?>
	<img src="http://i.oldbk.com/i/sh/<?=$model->img; ?>" title="<?=Html::encode($model->name); ?>" alt="<?=Html::encode($model->name); ?>">
</div>
