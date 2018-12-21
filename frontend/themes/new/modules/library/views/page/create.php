<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryPage */

$this->title = 'Create Library Page';
$this->params['breadcrumbs'][] = ['label' => 'Library Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Создание страницы</h5>
            </div>
            <div class="ibox-content">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>