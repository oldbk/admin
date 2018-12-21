<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryCategory */

$this->title = 'Обновить подсказку: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Редактирование подсказки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Обновление подсказки</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
