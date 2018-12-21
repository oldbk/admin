<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 09.09.17
 * Time: 00:04
 *
 * @var \common\models\oldbk\ConfigKoSettings[] $models
 */ ?>

<?php foreach ($models as $model):
	switch ($model->field_type) {
		case \common\models\oldbk\ConfigKoSettings::TYPE_DATETIMEPICKER:
			$model->field_value = date('Y-m-d H:i:s', $model->field_value);
			break;
	}
	?>
    <div>
        <?php if(empty($model->field_value)): ?>
            &nbsp;
        <?php else: ?>
		    <?= \yii\helpers\Html::encode($model->field_value); ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
