<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title>Admin OLDBK v0.1</title>
    <?php $this->head() ?>
</head>
<body class="gray-bg">
<?php $this->beginBody() ?>

<?= Alert::widget() ?>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
