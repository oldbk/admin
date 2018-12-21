<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\RateManager */
/* @var $conditionProvider \yii\data\ArrayDataProvider */

\frontend\assets\plugins\ICheckAsset::register($this);
\frontend\assets\plugins\PeityAsset::register($this);
\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);

?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Рейтинг: <?= Html::encode($model->name) ?></h5>
            </div>
            <div class="ibox-content">
                <?php $attributes  = [
                    'id',
                    'name',
                    'iteration',
                    'reward_till_days',
					[
						'attribute' => 'icon',
						'format' => 'raw',
						'value' => function() use ($model) {
							return Html::img(sprintf('http://i.oldbk.com/i/newd/%s', $model->icon));
						},
					],
					[
						'attribute' => 'link',
						'format' => 'raw',
						'value' => function() use ($model) {
							return Html::a($model->link, $model->link, ['target'=>'_blank']);
						},
					],
					[
						'attribute' => 'link_encicl',
						'format' => 'raw',
						'value' => function() use ($model) {
							return Html::a($model->link_encicl, $model->link_encicl, ['target'=>'_blank']);
						},
					],
					[
						'attribute' => 'is_enabled',
						'format' => 'raw',
						'value' => $model->is_enabled ? '<span class="label label-success">Да</span>'
							: '<span class="label label-danger">Нет</span>'
					],
                ];
                ?>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes,
                ]) ?>

                <p>
					<?= Html::a('Экспортировать', 'javascript:void(0)', [
						'class' => 'btn btn-primary ladda-button',
						'id' => 'export-btn',
						'data-url' => Url::to(['/rate/manager/export', 'id' => $model->id]),
						'data-style' => 'expand-left',
					]) ?>
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Вернуться', ['/rate/manager/index'], ['class' => 'btn btn-default']) ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="quest-condition-index">
    <p>
        <?= Html::a('Дата', ['/rate/condition/date', 'rate_id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Неделя', ['/rate/condition/week', 'rate_id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
        <?= Html::a('Диапазон дат', ['/rate/condition/date-range', 'rate_id' => $model->id], ['class' => 'btn btn-xs btn-success']) ?>
    </p>
</div>
<div id="quest-condition-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Список условий</h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin([
                'id' => 'rate-condition-grid',
                'enablePushState' => false,
                'scrollTo' => true
            ]); ?>
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $conditionProvider,
                'options' => [
                    'class' => 'table-responsive'
                ],
                'tableOptions' => [
                    'class' => 'table table-striped'
                ],
                'summary' => false,
                'columns' => [
                    [
                        'attribute' => 'name',
						'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'controller' => '/rate/condition',
                        'buttons' => [
                            'delete' => function($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['/rate/condition/delete', 'group_id' => $model['group'], 'rate_id' => $model['rate_id']], [
                                    'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this Record?'),'data-method' => 'post']);
                            }
                        ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>


<div class="rate-pool-index">
    <p>
        <?= Html::a('Привязать пул', ['/rate/pool/assign', 'rate_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
</div>
<div id="rate-pool-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Список пулов</h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin([
                'id' => 'rate-pool-grid',
                'enablePushState' => false,
                'scrollTo' => true
            ]); ?>
                <div class="placeholder">
                    <div class="ajax-loader"></div>
                </div>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<script>
    var $export_btn = $('#export-btn');
    $(function(){
        $export_btn.ladda();
        getPools(1);

        $(document.body).on('click', '#export-btn', function(){
            var $self = $(this);

            swal({
                title: "Вы уверены?",
                text: 'Запустить процесс экспорта рейтинга в игру? Будут экспортированы и пулы!!!',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, запустить процесс!",
                closeOnConfirm: false,
                cancelButtonText: 'Отмена',
                showLoaderOnConfirm: true
            }, function () {
                var triggers = {
                    'success'   : 'rate:export:success',
                    'error'     : 'rate:export:complete'
                };
                $ajax.json($self.data('url'),{},'get',triggers);
            });
        });

        $(window).on('rate:export:success', function(e, response) {
            swal("Готово!", "Процесс успешно завершен.", "success");
        });
        $(window).on('rate:export:error', function() {
            swal.close();
        });
    });

    function getPools(page)
    {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/rate/pool/list', 'rate_id' => $model->id]) ?>'+'&page='+page,
            success: function (response) {
                $('#rate-pool-block .placeholder').html(response);
            }
        });
    }
</script>
