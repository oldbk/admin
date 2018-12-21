<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\oldbk\Gamehelp;
use yii\helpers\Url;

\frontend\assets\plugins\LaddaAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\LibrarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список подсказок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quest-list-index">
	<?= Html::a('Создать подсказку', ['create'], ['class' => 'btn btn-success']) ?>
	<?= Html::a('Очистить кэш', 'javascript:void(0);', [
		'class' => 'btn btn-primary ladda-button',
		'id' => 'cache-btn',
		'data-url' => Url::to(['/gamehelp/default/cache']),
		'data-style' => 'expand-left',
	]) ?>

</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список подсказок</h5>
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
                        'name',
                        'dir',
                        [
                            'attribute' => 'is_enabled',
                            'format' => 'raw',
                            'value' => function($model){
                                return $model->is_enabled ? '<span class="label label-success">Да</span>'
                                    : '<span class="label label-danger">Нет</span>';
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '100'],
                            'template' => '{update} {delete}',
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    var $cache_btn = $('#cache-btn');
    $(function() {
        $cache_btn.ladda();

        $(document.body).on('click', '#cache-btn', function(){
            var $self = $(this);
            $self.ladda( 'start' );

            var triggers = {
                'success'   : 'gamehelp:cache:success',
                'error'     : 'gamehelp:cache:complete'
            };
            $ajax.json($self.data('url'),{},'get',triggers);
        });

        $(window).on('gamehelp:cache:success', function(e, response) {
            $cache_btn.ladda( 'stop' );
        });
        $(window).on('gamehelp:cache:error', function() {
            $cache_btn.ladda( 'stop' );
        });
    });
</script>