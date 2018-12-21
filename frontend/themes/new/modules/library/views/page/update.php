<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryPage */

$this->title = 'Update Library Page: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Library Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Обновление страницы</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
