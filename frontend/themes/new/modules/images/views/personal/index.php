<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\oldbk\Users;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\LibraryPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Персональные картинки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Выбрать игрока</h5>
            </div>
            <div class="ibox-content">
		
                <?php Pjax::begin(['id' => 'quest-grid']); ?>
                <?= \yii\grid\GridView::widget([
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
                        'login',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '100'],
                            'template' => '{view}',
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>