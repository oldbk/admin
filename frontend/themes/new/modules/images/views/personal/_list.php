<?php
use yii\helpers\Html;
?>
<div class="imgshadow">
	<?= Html::checkbox('shadows[]', false,['value' => $model->id]);?>
	<img src="http://i.oldbk.com/i/shadow/<?=Html::encode($model->name); ?>.gif">
</div>

