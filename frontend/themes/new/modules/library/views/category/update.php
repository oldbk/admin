<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryCategory */

$this->title = 'Update Library Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Library Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Обновление категории</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
