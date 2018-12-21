<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\oldbk\Users;

/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\LibraryPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\LaddaAsset::register($this);

$this->title = 'Редактирование ботов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список ботов</h5>
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
                            'template' => '{update}',
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>