<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\oldbk\Wordfilter */

$this->title = 'Добавить слово';
$this->params['breadcrumbs'][] = ['label' => 'Wordfilters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wordfilter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
