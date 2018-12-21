<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryPage */

$this->title = 'Обновить инфу о боте: ' . $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Обновить инфу о боте', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Обновление информации о боте</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
