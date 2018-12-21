<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\event\EventWcSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);
\frontend\assets\plugins\LaddaAsset::register($this);


?>
<div class="loto-list-index">
    <p>
        <?= Html::a('Добавить матч', ['create'], ['class' => 'btn btn-success']) ?>
		<?= Html::a('Экспортировать', 'javascript:void(0)', [
			'class' => 'btn btn-primary ladda-button',
			'id' => 'export-btn',
			'data-url' => Url::to(['/event/wc18/export']),
			'data-style' => 'expand-left',
		]) ?>
    </p>
</div>

<?php Pjax::begin([
	'id' => 'wc18-grid',
	'timeout' => false,
	'scrollTo' => 1,
]); ?>

    <div class="row">
		<?php foreach ($dataProvider->getModels() as $model): ?>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6 b-r text-left">
								<div>
									(<?= $model->id ?>) <?= $model->team1->name; ?>
                                </div>
								<div>
									<?= $model->team2->name; ?>
                                </div>
                            </div>
                            <div class="col-sm-6 text-center">
                                <div>
									<?= Yii::$app->formatter->asDate($model->datetime, 'php:D, d.m H:i'); ?>
                                </div>
                                <div>
                                    <?php if($model->datetime < time()): ?>
										<?php if($model->who_win === null): ?>
											<?= Html::a('Добавить счет', ['/event/wc18/result', 'id' => $model->id], ['class' => 'btn btn-xs btn-primary popup-change']) ?>
										<?php else: ?>
                                            <small>Результат: <?= sprintf('%d:%d', $model->team1_res, $model->team2_res) ?></small>
										<?php endif; ?>
                                    <?php else: ?>
                                        <small>Событие еще не началось</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
<?php Pjax::end(); ?>

<div class="modal inmodal" id="change-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">

        </div>
    </div>
</div>

<script>
    var $export_btn = $('#export-btn');
    $(function(){
        $export_btn.ladda();

        $(document.body).on('click', '#export-btn', function(){
            var $self = $(this);

            swal({
                title: "Вы уверены?",
                text: 'Запустить процесс экспорта матчей в игру?',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, запустить процесс!",
                closeOnConfirm: false,
                cancelButtonText: 'Отмена',
                showLoaderOnConfirm: true
            }, function () {
                var triggers = {
                    'success'   : 'wc18:export:success',
                    'error'     : 'wc18:export:complete'
                };
                $ajax.json($self.data('url'),{},'get',triggers);
            });
        });

        $(window).on('wc18:export:success', function(e, response) {
            swal("Готово!", "Процесс успешно завершен.", "success");
        });
        $(window).on('wc18:export:error', function() {
            swal.close();
        });

        $(document.body).on('click', '.popup-change', function(e){
            e.preventDefault();

            var $self = $(this);

            $('#change-modal').modal({
                'remote': $self.attr('href')
            });
        });

        $('#change-modal').on('hide.bs.modal', function (e) {
            $('#change-modal').removeData();
            $('#change-modal .modal-content').html('');
        });

        $('#change-modal').on('loaded.bs.modal', function(){
            sendWc();
        });

    });

    function sendWc()
    {
        $('form#form-wc-change [type="submit"]').on('click', function(e) {
            e.preventDefault();

            var form = $(this).closest('form');
            var formData = form.serialize();
            $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log('success');
                    if(data.status == 1) {
                        $('#change-modal').modal('hide');
                        $.pjax.reload({container:"#wc18-grid"});
                    } else {
                        $('#change-modal .modal-content').html(data.html);
                        sendWc()
                    }
                },
                error: function () {
                    alert("Something went wrong");
                }
            });
        });
    }

</script>
