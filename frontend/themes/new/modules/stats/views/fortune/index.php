<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use \yii\helpers\Url;
use yii\grid\GridView;
use \common\helper\CurrencyHelper;

\frontend\assets\plugins\DateRangPickerAsset::register($this);

?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Статистика колеса фортуны</h5>
            </div>
            <div class="ibox-content">
                <div class="form-group">
		<form method="GET" id="dateform">
		Период <input type="text" name="daterange" id="daterange" value="<?=date("d/m/Y",$range_start);?> - <?=date("d/m/Y",$range_end);?>">
		</div>
		</form>
		<div class="form-group">
		<?= GridView::widget([
		    'dataProvider' => $sstats,
		    'options'=> ['style' => 'width:200px'],
		    'layout' => "{items}",
		    'columns' => [
		        ['attribute' => 'status', 'header' => 'Номер броска'],
		        ['attribute' => 'cc', 'header' => 'Всего бросков'],
		        ['header' => 'Потрачено',                             
				'value' => function($model) {
					return $model['money']." ".CurrencyHelper::getCurrency()[$model['moneytype']].".";
                            	}
			
			],
		    ],
		]) ?>
		</div>
		<div class="form-group">
		<strong>Всего участвовало</strong>: <?= $uowner; ?><br />
		<strong>Итого</strong>: 
			<?= $mstats[CurrencyHelper::CURRENCY_KR];   ?> <?=CurrencyHelper::getCurrency()[CurrencyHelper::CURRENCY_KR]?>., 
			<?= $mstats[CurrencyHelper::CURRENCY_EKR];  ?> <?=CurrencyHelper::getCurrency()[CurrencyHelper::CURRENCY_EKR]?>., 
			<?= $mstats[CurrencyHelper::CURRENCY_GOLD]; ?> <?=CurrencyHelper::getCurrency()[CurrencyHelper::CURRENCY_GOLD]?>. 
                </div>
		<div class="form-group">
		<?= GridView::widget([
		    'dataProvider' => $istats,
		    'options'=> ['style' => 'width:500px'],
		    'layout' => "{items}",
		    'columns' => [
		        ['attribute' => 'name', 'header' => 'Название'],
		        ['attribute' => 'cc', 'header' => 'Количество'],
		    ],
		]) ?>
		</div>                         
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
        var datepicker = $('#daterange');

        datepicker.daterangepicker({
            autoUpdateInput: true,
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
                .val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
		$("#dateform").submit();
        });

        datepicker.on('cancel.daterangepicker', function(ev, picker) {
            $(this)
                .val('');
        });
});
</script>