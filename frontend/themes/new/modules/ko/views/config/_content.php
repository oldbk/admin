<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use \yii\helpers\Url;
use \common\models\Notepad;

/* @var $this yii\web\View */
/* @var $cp \common\models\oldbk\Variables */
/* @var $friday \common\models\oldbk\Variables *
/* @var $tykvabot \common\models\oldbk\Variables */
/* @var $demontime \common\models\oldbk\Variables */

\frontend\assets\plugins\SweetAlertAsset::register($this);
\frontend\assets\plugins\DateTimePickerAsset::register($this);
?>
<div class="row">
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Еврокредиты +</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Подарите себе праздник!</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Установи изображение»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Событие «Летний дух стойкости»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Квест «Зимний штурм»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Событие «Весенний дух стойкости»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Опыт»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «+% Репутации»!</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Ваучеры коммерческого отдела»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>«Руны»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>«Трехсторонний бой»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Локация «Руины»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>«Подарки новичкам»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>«Боевые елочки»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>«С новым 2017 годом!»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Скупка»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Благодарность Богов»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Событие «Happy Halloween»!</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>«Елочное безумие!»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Событие «Дни открытых забрал»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>«Пасхальные яйца»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Особые боевые букеты</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Рунная гонка»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Зов стихии»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Выгодная покупка»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>1 апреля «Неделя веселья»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>«Покупка золотых монет»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Событие «Победный май»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Рунное могущество»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Мячи «Евро-2016»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Флаги стран «Евро-2016»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Свитки рунного опыта</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Свиток великих побед</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Событие «Жаркий август»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Свобода выбора»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Стабильное улучшение»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Двойная выгода»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Событие «Марафон знаний»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Клановая казна»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Выгодная покупка»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Событие «Проводы осени»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Свобода выбора»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Приглашаем на годовщину ОлдБК!</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>С днем Святого Валентина!</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Неделя беспредела</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Событие «Весенний привал»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Скидка 50% на все премиум-аккаунты</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Праздничная Лотерея!</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Снежное Волшебство»</h5>
            </div>
            <div class="ibox-content"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Акция «Волна Хаоса»</h5>
            </div>
            <div class="ibox-content"></div>
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