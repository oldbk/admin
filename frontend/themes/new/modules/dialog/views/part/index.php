<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DialogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dialog Quests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dialog-quest-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dialog Quest', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bot_id',
            'item_id',
            'item_type',
            'action_type',
            // 'message',
            // 'is_saved',
            // 'updated_at',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
