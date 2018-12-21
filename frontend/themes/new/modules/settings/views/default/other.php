<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use \yii\helpers\Url;
use \common\models\Notepad;

/* @var $this yii\web\View */
/* @var $cp \common\models\oldbk\Variables */
/* @var $friday \common\models\oldbk\Variables */
/* @var $tykvabot \common\models\oldbk\Variables */

\frontend\assets\plugins\SweetAlertAsset::register($this);
\frontend\assets\plugins\DateTimePickerAsset::register($this);
?>
<div class="row">
    <div class="col-lg-2">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Пятница</h5>
            </div>
            <div class="ibox-content">
                Время: <?= (new DateTime())->setTimestamp($friday->value)->format('d.m.Y H:i:s') ?>
                <div style="text-align: center;margin-top: 10px;">
                    <?= Html::a('Изменить', ['/settings/default/date', 'field' => 'friday_time'], ['class' => 'btn btn-xs btn-primary popup-change']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="ibox ">
            <div class="ibox-title">
                	<h5>Тыква</h5>
            </div>
            <div class="ibox-content">
                Время: <?= (new DateTime())->setTimestamp($tykvabot->value)->format('d.m.Y H:i:s') ?>
                <div style="text-align: center;margin-top: 10px;">
                    <?= Html::a('Изменить', ['/settings/default/date', 'field' => 'tykvabot_time'], ['class' => 'btn btn-xs btn-primary popup-change']) ?>
                </div>
            </div>
        </div>
    </div>    
    <div class="col-lg-2">
        <div class="ibox ">
            <div class="ibox-title">
                	<h5>Демон Велиар</h5>
            </div>
            <div class="ibox-content">
                Время: <?= (new DateTime())->setTimestamp($demontime->value)->format('d.m.Y H:i:s') ?>
                <div style="text-align: center;margin-top: 10px;">
                    <?= Html::a('Изменить', ['/settings/default/date', 'field' => 'demon_time'], ['class' => 'btn btn-xs btn-primary popup-change']) ?>
                </div>
            </div>
        </div>
    </div>     
    <div class="col-lg-2">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Кнопка на ЦП</h5>
            </div>
            <div class="ibox-content">
                Время: <?= (new DateTime())->setTimestamp($cp->value)->format('d.m.Y H:i:s') ?>
                <div style="text-align: center;margin-top: 10px;">
                    <?= Html::a('Изменить', ['/settings/default/date', 'field' => 'cp_attack_time_start'], ['class' => 'btn btn-xs btn-primary popup-change']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Волна хаоса Знахарь</h5>
            </div>
            <div class="ibox-content">
                Время: <?= (new DateTime())->setTimestamp($haos_start->value)->format('d.m.Y H:i:s') ?> -
                    <?= (new DateTime())->setTimestamp($haos_end->value)->format('d.m.Y H:i:s') ?>
                <div style="text-align: center;margin-top: 10px;">
                    <?= Html::a('Изменить', ['/settings/default/haos'], ['class' => 'btn btn-xs btn-primary popup-change']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="date-change-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">

        </div>
    </div>
</div>
<script>
    $(function(){
        $(document.body).on('click', '.popup-change', function(e){
            e.preventDefault();

            var $self = $(this);

            $('#date-change-modal').modal({
                'remote': $self.attr('href')
            });
        });
        $('#date-change-modal').on('loaded.bs.modal', function(){
            $('.datetime').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });

        $('#date-change-modal').on('hide.bs.modal', function (e) {
            $('#date-change-modal').removeData();
        })
    });
</script>