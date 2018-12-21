<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?= Html::encode($this->title) ?></h5>
            </div>
            <div class="ibox-content">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username',
                        'email:email',
                        'status',
                        [
                            'attribute' => 'created_at',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                        ],
                        'short_description',
                    ],
                ]) ?>

                <p>
                    <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('Вернуться', ['/users/user/index'], ['class' => 'btn btn-default']) ?>
                </p>
            </div>
        </div>
    </div>
</div>