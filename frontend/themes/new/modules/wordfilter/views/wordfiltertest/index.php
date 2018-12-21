<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\WordfilterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проверка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wordfilter-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::beginForm('','POST'); ?>

    <?= Html::input('text','check',$CheckData,['class' => 'form-control']); ?>
    <br />	
    <p>
        <?= Html::submitButton('Проверить предложение', ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <? if (strlen($result)) { ?>
	<strong>Результат:</strong> <?= $result ?>


	<? } ?>
    </p>

    <?= Html::endForm(); ?>
</div>
