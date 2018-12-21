<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\LaddaAsset::register($this);

?>
<div class="library-list-index">
    <p>
        <?= Html::a('Создать новый список', ['create'], ['class' => 'btn btn-success']) ?>
	<?= Html::a('Очистить кэш', 'javascript:void(0);', [
		'class' => 'btn btn-primary ladda-button',
		'id' => 'cache-btn',
		'data-url' => Url::to(['/library/page/cache']),
		'data-style' => 'expand-left',
	]) ?>
    </p>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Списки</h5>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin([
                    'id' => 'library-pocket-grid',
                    'timeout' => false,
                    'scrollTo' => 1,
                ]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout'=>"{pager}\n{items}\n{pager}",
                    'options' => [
                        'class' => 'table-responsive'
                    ],
                    'tableOptions' => [
                        'class' => 'table table-striped'
                    ],
                    'summary' => false,
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'headerOptions' => [
                                'style' => 'width: 75px;'
                            ],
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'attribute' => 'name',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'attribute' => 'itemCount'
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            'filter' => false,
                        ],
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
    var $cache_btn = $('#cache-btn');
    $(function() {
        $cache_btn.ladda();

        $(document.body).on('click', '#cache-btn', function(){
            var $self = $(this);
            $self.ladda( 'start' );

            var triggers = {
                'success'   : 'library:cache:success',
                'error'     : 'library:cache:complete'
            };
            $ajax.json($self.data('url'),{},'get',triggers);
        });

        $(window).on('library:cache:success', function(e, response) {
            $cache_btn.ladda( 'stop' );
        });
        $(window).on('library:cache:error', function() {
            $cache_btn.ladda( 'stop' );
        });
    });
</script>