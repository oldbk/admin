<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use \yii\helpers\Url;
use yii\grid\GridView;

?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Классы персонажей онлайн</h5>
            </div>
            <div class="ibox-content">
                <div class="form-group">
		<?= GridView::widget([
		    'dataProvider' => $stats,
		    'columns' => [
		        ['attribute' => 'name', 'header' => 'Класс'],
		        ['attribute' => 'cnt', 'header' => 'Кол-во'],
		    ],
		]) ?>
                </div>
            </div>
        </div>
    </div>
</div>