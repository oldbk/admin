<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryCategory */

$this->title = 'Create Library Category';
$this->params['breadcrumbs'][] = ['label' => 'Library Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Создание категории</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>