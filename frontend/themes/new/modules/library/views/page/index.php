<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\oldbk\LibraryCategory;
use common\models\oldbk\LibraryPage;

/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\LibraryPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\LaddaAsset::register($this);

$this->title = 'Страницы библиотеки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="library-list-index">
	<?= Html::a('Создать страницу', ['create'], ['class' => 'btn btn-success']) ?>
	<?= Html::a('Очистить кэш', 'javascript:void(0);', [
		'class' => 'btn btn-primary ladda-button',
		'id' => 'cache-btn',
		'data-url' => Url::to(['/library/page/cache']),
		'data-style' => 'expand-left',
	]) ?>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список страниц</h5>
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
                        'order_position',
                        [
                            'attribute' => 'category_id',
                            'value' => 'category.title',
                            'label' => 'Категория',
                            'filter' => ArrayHelper::map(LibraryCategory::find()
                                ->orderBy('title asc')
                                ->all(), 'id', 'title')
                        ],
                        'page_title',
                        'dir',
                        [
                            'attribute' => 'type',
                            'format' => 'raw',
                            'filter' => LibraryPage::getTypeList(),
                            'value' => function($model) {
                                return LibraryPage::getTypeList()[$model->type];
                            }
                        ],
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
                            'template' => '{update} {delete} {up} {down}',
                            'buttons' => [
                                //view button
                                'up' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['/library/page/up', 'id' => $model->id], [
                                        'title' => 'Move UP',
                                    ]);
                                },
                                'down' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['/library/page/down', 'id' => $model->id], [
                                        'title' => 'Move DOWN',
                                    ]);
                                },
                            ],
                            'visibleButtons' => [
                                'up' => function ($model, $key, $index) {
                                    return $model->order_position > 1;
                                },
                                'down' => function ($model, $key, $index) use ($dataProvider) {
                                    return $index != $dataProvider->totalCount - 1;
                                },
                            ]
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