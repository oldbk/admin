<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\QuestPartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\ICheckAsset::register($this);
\frontend\assets\plugins\PeityAsset::register($this);
?>
<div class="quest-part-index">
    <p>
        <?= Html::a('Создать часть', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список частей</h5>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin(['id' => 'quest-part-grid']); ?>
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
                        [
                            'class' => \yii\grid\CheckboxColumn::className(),
                            'checkboxOptions' => [
                                'class' => 'i-checks',
                            ],
                            'multiple' => false,
                            'headerOptions' => [
                                'width' => '40',
                            ],
                        ],
                        [
                            'attribute' => 'part_number',
                            'headerOptions' => [
                                'width' => '90',
                            ],
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ]
                        ],
                        [
                            'attribute' => 'quest.name',
                            'label' => 'Квест'
                        ],
                        'name',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '80'],
                            'template' => '{view} {update} {delete}',
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $("#quest-part-grid").on("pjax:end", function() {
            events();
        });
        events();
    });

    function events()
    {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
    }
</script>
