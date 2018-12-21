<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\loto\LotoItem;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LotoPocketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);


?>
<div class="loto-list-index">
    <p>
        <?= Html::a('Создать новый список', ['create'], ['class' => 'btn btn-success']) ?>

    	<?= Html::a('Экспортировать новогодние ларцы', 'javascript:void(0)', [
	        'class' => 'btn btn-primary ladda-button',
	        'id' => 'export-larci-btn',
	        'data-url' => 'http://capitalcity.oldbk.com/larsync.php',
	        'data-style' => 'expand-left',
	]) ?>

    	<?= Html::a('Экспортировать кота в мешке', 'javascript:void(0)', [
	        'class' => 'btn btn-primary ladda-button',
	        'id' => 'export-kot-btn',
	        'data-url' => 'http://capitalcity.oldbk.com/kotsync.php',
	        'data-style' => 'expand-left',
	]) ?>


    	<?= Html::a('Экспортировать пасхальные яйца', 'javascript:void(0)', [
	        'class' => 'btn btn-primary ladda-button',
	        'id' => 'export-egg-btn',
	        'data-url' => 'http://capitalcity.oldbk.com/eggsync.php',
	        'data-style' => 'expand-left',
	]) ?>

		<?= Html::a('Экспортировать ЧМ 2018', 'javascript:void(0)', [
			'class' => 'btn btn-primary ladda-button',
			'id' => 'export-wc-btn',
			'data-url' => Url::to(['/loto/export/wc']),
			'data-style' => 'expand-left',
		]) ?>
		
    	<?= Html::a('Экспортировать «Праздник урожая», осень-2018', 'javascript:void(0)', [
	        'class' => 'btn btn-primary ladda-button',
	        'id' => 'export-urajai-btn',
	        'data-url' => 'http://capitalcity.oldbk.com/urojaisync.php',
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
                    'id' => 'loto-pocket-grid',
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
                                'style' => 'width: 50px;'
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
                            'attribute' => 'itemPrime'
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            'filter' => false,
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '80'],
                            'template' => '{view} {clone} {update} {delete}',
                            'buttons' => [
                                'clone' => function ($url, $model, $key) {
                                    return Html::a(
                                        '<i class="fa fa-copy"></i>',
                                        ['/loto/pocket/clone', 'id' => $model->id],
                                        ['title' => 'Клонировать']
                                    );
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
    var $export_wc_btn = $('#export-wc-btn');
    $export_wc_btn.ladda();
    $(document.body).on('click', '#export-wc-btn', function(){
        var $self = $(this);

        swal({
            title: "Вы уверены?",
            text: 'Запустить процесс экспорта ЧМ2018 в игру?',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да, запустить процесс!",
            closeOnConfirm: false,
            cancelButtonText: 'Отмена',
            showLoaderOnConfirm: true
        }, function () {
            var triggers = {
                'success'   : 'export:wc:success',
                'error'     : 'export:wc:complete'
            };
            $ajax.json($self.data('url'),{},'get',triggers);
        });
    });
    $(window).on('export:wc:success', function(e, response) {
        swal("Готово!", "Процесс успешно завершен.", "success");
    });
    $(window).on('export:wc:error', function() {
        swal.close();
    });


    var $export_larci_btn = $('#export-larci-btn');
    $export_larci_btn.ladda();


    $(document.body).on('click', '#export-larci-btn', function(){
        var $self = $(this);

        swal({
            title: "Вы уверены?",
            text: 'Запустить процесс экспорта ларцов в игру?',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да, запустить процесс!",
            closeOnConfirm: false,
            cancelButtonText: 'Отмена',
            showLoaderOnConfirm: true
        }, function () {
            var triggers = {
                'success'   : 'lotolarci:export:success',
                'error'     : 'lotolarci:export:error'
            };
            $ajax.request($self.data('url'),{},'get',triggers,"text");
        });
    });

    $(window).on('lotolarci:export:success', function(e, response) {
        if (response != "EXPORT OK") {
            swal("Готово!", "Ответ процесса: "+response, "error");
        } else {
            swal("Готово!", "Ответ процесса: "+response, "success");
        }
    });
    $(window).on('lotolarci:export:error', function() {
        swal.close();
    });

    // kot v meshke
    var $export_kot_btn = $('#export-kot-btn');
    $export_kot_btn.ladda();

    $(document.body).on('click', '#export-kot-btn', function(){
        var $self = $(this);

        swal({
            title: "Вы уверены?",
            text: 'Запустить процесс экспорта кота в мешке в игру?',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да, запустить процесс!",
            closeOnConfirm: false,
            cancelButtonText: 'Отмена',
            showLoaderOnConfirm: true
        }, function () {
            var triggers = {
                'success'   : 'lotokot:export:success',
                'error'     : 'lotokot:export:error'
            };
            $ajax.request($self.data('url'),{},'get',triggers,"text");
        });
    });

    $(window).on('lotokot:export:success', function(e, response) {
        if (response != "EXPORT OK") {
            swal("Готово!", "Ответ процесса: "+response, "error");
        } else {
            swal("Готово!", "Ответ процесса: "+response, "success");
        }
    });
    $(window).on('lotokot:export:error', function() {
        swal.close();
    });

    // пасхальные яйца
    var $export_kot_btn = $('#export-egg-btn');
    $export_kot_btn.ladda();

    $(document.body).on('click', '#export-egg-btn', function(){
        var $self = $(this);

        swal({
            title: "Вы уверены?",
            text: 'Запустить процесс экспорта пасхальных яиц в игру?',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да, запустить процесс!",
            closeOnConfirm: false,
            cancelButtonText: 'Отмена',
            showLoaderOnConfirm: true
        }, function () {
            var triggers = {
                'success'   : 'lotoegg:export:success',
                'error'     : 'lotoegg:export:error'
            };
            $ajax.request($self.data('url'),{},'get',triggers,"text");
        });
    });

    $(window).on('lotoegg:export:success', function(e, response) {
        if (response != "EXPORT OK") {
            swal("Готово!", "Ответ процесса: "+response, "error");
        } else {
            swal("Готово!", "Ответ процесса: "+response, "success");
        }
    });
    $(window).on('lotoegg:export:error', function() {
        swal.close();
    });
    
 // урожай осенний 2018
    var $export_urajai_btn = $('#export-urajai-btn');
    $export_urajai_btn.ladda();

    $(document.body).on('click', '#export-urajai-btn', function(){
        var $self = $(this);

        swal({
            title: "Вы уверены?",
            text: 'Запустить процесс экспорта «Праздник урожая», осень-2018 в игру?',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да, запустить процесс!",
            closeOnConfirm: false,
            cancelButtonText: 'Отмена',
            showLoaderOnConfirm: true
        }, function () {
            var triggers = {
                'success'   : 'lotourajai:export:success',
                'error'     : 'lotourajai:export:error'
            };
            $ajax.request($self.data('url'),{},'get',triggers,"text");
        });
    });

    $(window).on('lotourajai:export:success', function(e, response) {
        if (response != "EXPORT OK") {
            swal("Готово!", "Ответ процесса: "+response, "error");
        } else {
            swal("Готово!", "Ответ процесса: "+response, "success");
        }
    });
    $(window).on('lotourajai:export:error', function() {
        swal.close();
    });

</script> 