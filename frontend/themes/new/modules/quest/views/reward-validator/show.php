<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 27.08.16
 * Time: 22:03
 *
 * @var \common\models\validator\QuestValidatorItemTask[] $models
 */ ?>

<?php foreach ($models as $model): ?>
    <?= $model->info->getDescription() ?>
    <hr>
<?php endforeach;; ?>
