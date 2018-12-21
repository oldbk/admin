<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 09.09.17
 * Time: 00:04
 *
 * @var \common\models\oldbk\ConfigKoSettings[] $models
 */ ?>

<?php foreach ($models as $model): ?>
    <div>
		<?= \yii\helpers\Html::encode($model->field_name); ?>
    </div>
<?php endforeach; ?>
