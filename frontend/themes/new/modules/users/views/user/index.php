<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<div class="user-list-index">
    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Пользователи</h5>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'options' => [
                        'class' => 'table-responsive'
                    ],
                    'tableOptions' => [
                        'class' => 'table table-striped'
                    ],
                    'summary' => false,
                    'columns' => [
                        'id',
                        'username',
                        'email:email',
                        // 'auth_key',
                        // 'status',
                        // 'created_at',
                        // 'updated_at',
                        // 'short_description',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>