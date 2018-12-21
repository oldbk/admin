<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use \yii\helpers\Url;
use \common\models\Notepad;

/* @var $this yii\web\View */
/* @var $searchModel common\models\oldbk\search\DilerDeloSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $notepad \common\models\Notepad */
/* @var $sum float */

\frontend\assets\plugins\DateRangPickerAsset::register($this);
\frontend\assets\plugins\CKEditorAsset::register($this);
\frontend\assets\plugins\LaddaAsset::register($this);

?>
<style>
    .save-btn, .cancel-btn {
        display: none;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Заметка</h5>
            </div>
            <div class="ibox-content">
                <div class="form-group">
                    <?= Html::a('Сохранить', 'javascript:void(0)', [
                        'class' => 'btn btn-primary save-btn ladda-button btn-xs',
                        'data-style' => 'expand-left'
                    ]) ?>
                    <?= Html::a('Отмена', 'javascript:void(0)', ['class' => 'btn btn-default cancel-btn  btn-xs']) ?>
                    <?= Html::a('Редактировать', 'javascript:void(0)', ['class' => 'btn btn-success edit-btn  btn-xs']) ?>
                </div>
                <div class="row notepad-message" id="notepad-message">
                    <?= $notepad->message; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php Pjax::begin([
        'id' => 'diler-grid',
        'timeout' => false,
        'scrollTo' => 1,
    ]); ?>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                Сумма: <?= $sum; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Список продаж</h5>
            </div>
            <div class="ibox-content">

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
                        [
                            'attribute' => 'date',
                            'format' =>  ['date', 'dd.MM.Y HH:mm:ss'],
                            'filterOptions' => [
                                'class' => 'daterange'
                            ],
                        ],
                        [
                            'attribute' => 'dilername'
                        ],
                        [
                            'attribute' => 'owner'
                        ],
                        [
                            'attribute' => 'sum_ekr'
                        ],
                        [
                            'attribute' => 'paysyst',
                            'filter' => \common\models\oldbk\DilerDelo::getPaysysts()
                        ],
                        [
                            'attribute' => 'addition',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>

<script>
    var old_text = null;
    $(function(){
        $("#diler-grid").on("pjax:end", function() {
            events();
        });
        events();
        $('.save-btn').ladda();

        $(document.body).on('click', '.edit-btn', function(){
            $(this).hide();
            CKEDITOR.replace( 'notepad-message');
            CKEDITOR.instances['notepad-message'].focus();

            old_text = CKEDITOR.instances['notepad-message'].getData();
            $('.save-btn, .cancel-btn').show();
        });
        $(document.body).on('click', '.cancel-btn', function(){
            clearNotepad();
            $('#notepad-message').html(old_text);
        });
        $(document.body).on('click', '.save-btn', function(){
            var triggers = {
                'success'   : 'notepad:save:success',
                'error'     : 'notepad:save:error'
            };
            var data = {
                'message' : CKEDITOR.instances['notepad-message'].getData()
            };
            $('.save-btn').ladda( 'start' );
            $ajax.json('<?= Url::to(['/notepad/save', 'id' => $notepad->id]) ?>', data, null, triggers);
        });
        $(window).on('notepad:save:success', function(e, response) {
            $('.save-btn').ladda( 'stop' );
            clearNotepad();
        });
    });

    function clearNotepad()
    {
        $('.save-btn, .cancel-btn').hide();
        $('.edit-btn').show();
        CKEDITOR.instances['notepad-message'].destroy();
    }

    function events()
    {
        var datepicker = $('[name="DilerDeloSearch[date]"]');

        datepicker.daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY',
                cancelLabel: 'Clear'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });

        datepicker.on('apply.daterangepicker', function(ev, picker) {
            $(this)
                .val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'))
                .trigger('change');
        });

        datepicker.on('cancel.daterangepicker', function(ev, picker) {
            $(this)
                .val('')
                .trigger('change');
        });
    }
</script>