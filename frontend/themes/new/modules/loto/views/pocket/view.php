<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\loto\LotoItem;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LotoItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchExport common\models\search\LotoExportSearch */
/* @var $dataProviderExport yii\data\ActiveDataProvider */
/* @var $Pocket \common\models\loto\LotoPocket */


\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);
?>


<div class="loto-list-index">
    <p>
        <?= Html::a('Симуляция', Url::to(['/loto/item/simulation']), ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить предмет', ['/loto/item/item', 'pocket_id' => $Pocket->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Добавить реликт', ['/loto/item/ability', 'pocket_id' => $Pocket->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Добавить CUSTOM', ['/loto/item/custom', 'pocket_id' => $Pocket->id], ['class' => 'btn btn-success']) ?>
    </p>
</div>

<?php Pjax::begin([
    'id' => 'loto-item-grid',
    'timeout' => false,
    'scrollTo' => 1,
]); ?>
<div class="row">
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Баланс ЕКР</h5>
            </div>
            <div class="ibox-content">
                <ul class="unstyled">
                    <li>Наименований: <?= $searchModel->count_ekr ?></li>
                    <li>Кол-во: <?= $searchModel->count_sum_ekr ?></li>
                    <li>Сумма: <?= $searchModel->cost_ekr ?></li>
                    <li>Себестоимость: <?= Yii::$app->formatter->asDecimal($searchModel->prime_ekr, 2); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Баланс КР</h5>
            </div>
            <div class="ibox-content">
                <ul class="unstyled">
                    <li>Наименований: <?= $searchModel->count_kr ?></li>
                    <li>Кол-во: <?= $searchModel->count_sum_kr ?></li>
                    <li>Сумма: <?= $searchModel->cost_kr ?></li>
                    <li>Себестоимость: <?= Yii::$app->formatter->asDecimal($searchModel->prime_kr, 2); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список <?= $Pocket->name; ?></h5>
            </div>
            <div class="ibox-content">
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
                                'style' => 'width: 50px;'
                            ],
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'attribute' => 'item_info_name',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'value' => function($model) {
                                return $model->info->getViewName();
                            },
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'item_name',
                            'filter' => Html::activeDropDownList($searchModel, 'item_name', \common\models\itemInfo\BaseInfo::getTypeTitles(), ['class'=>'form-control','prompt' => '']),
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'value' => function($model) {
                                return \common\models\itemInfo\BaseInfo::getTypeTitles()[$model->info->getItemType()];
                            },
                        ],
                        [
                            'attribute' => 'cost',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'value' => function($model) {
                                return $model->cost.' '.\common\helper\CurrencyHelper::getCurrency()[$model->cost_type];
                            },
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'stock',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                            'format' => 'raw',
                            'filter' => Html::activeDropDownList($searchModel, 'stock', LotoItem::getStockList(), ['class'=>'form-control','prompt' => '']),
                            'value' => function($model) {
                                return $model->stock ? '<span class="label label-success">Да</span>'
                                    : '<span class="label label-danger">Нет</span>';
                            },
                        ],
                        [
                            'attribute' => 'count',
                            'label' => 'Кол-во',
                            'contentOptions' => [
                                'style' => 'text-align:center'
                            ],
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            'filter' => false,
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
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<span class="glyphicon glyphicon-eye-open"></span>',
                                        $model->info->getViewLink(),
                                        ['class' => 'view-item']
                                    );
                                },
                            ],
                            'visibleButtons' => [
                                'view' => function ($model, $key, $index) {
                                    return $model->info->getItemType() === \common\models\itemInfo\BaseInfo::ITEM_TYPE_ITEM;
                                }
                            ],
                            'controller' => '/loto/item'
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>

<div class="loto-list-index">
    <p>
        <?= Html::a('Экспортировать', 'javascript:void(0);', [
            'class' => 'btn btn-primary ladda-button',
            'id' => 'export-btn',
            'data-url' => Url::to(['/loto/pocket/export', 'id' => $Pocket->id]),
            'data-style' => 'expand-left',
        ]) ?>
    </p>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Лог экспорта</h5>
            </div>
            <div class="ibox-content">
                <?php Pjax::begin([
                    'id' => 'pocket-export-grid',
                    'timeout' => false,
                    'scrollTo' => 1,
                ]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProviderExport,
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
                                'style' => 'width: 50px;'
                            ],
                        ],
                        [
                            'attribute' => 'user.username',
                        ],
                        [
                            'attribute' => 'loto_num',
                        ],
                        [
                            'attribute' => 'exported_at',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="loto-item-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div data-js="loto-modal-content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<script>
    var $export_btn = $('#export-btn');
    $(function(){
        $export_btn.ladda();

        $(document.body).on('click', '.view-item', function(e){
            e.preventDefault();

            var $self = $(this);
            var triggers = {
                'success'   : 'loto:item:view:success'
            };
            $ajax.json($self.prop('href'),{},'get',triggers);
        });

        $(window).on('loto:item:view:success', function(e, response) {
            $('[data-js="loto-modal-content"]').html(response.content);
            $('#loto-item-modal').modal('show');
        });

        $(document.body).on('click', '#export-btn', function(){
            var $self = $(this);

            swal({
                title: "Вы уверены?",
                text: 'Запустить процесс экспорта списка в игру?',
                type: "input",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, запустить процесс!",
                closeOnConfirm: false,
                inputPlaceholder: "Введите № тиража",
                cancelButtonText: 'Отмена',
                showLoaderOnConfirm: true
            }, function (inputValue) {
                if (inputValue === "") {
                    swal.showInputError("Вы должны ввести № тиража!");
                    return false
                }

                var triggers = {
                    'success'   : 'loto:export:success',
                    'error'     : 'loto:export:complete'
                };
                $ajax.json($self.data('url'),{'loto_num': inputValue},'get',triggers);
            });
        });

        $(window).on('loto:export:success', function(e, response) {
            swal("Готово!", "Процесс успешно завершен.", "success");
            $.pjax.reload({container: '#pocket-export-grid'});
        });
        $(window).on('loto:export:error', function() {
            swal.close();
        });
    });
</script>
