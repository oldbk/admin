<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\QuestMedalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="quest-list-index">
    <?= Html::a('Создать медаль', ['create'], ['class' => 'btn btn-success']) ?>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список медалей</h5>
            </div>
            <div class="ibox-content">
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
                        'name',
                        'key',
                        'day_count',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '80'],
                            'template' => '{update}{delete}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>