<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 29.03.2016
 *
 * @var $model \common\models\oldbk\Shop|\common\models\oldbk\Eshop|\common\models\oldbk\Cshop
 */
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox-title">
            <h5>Общая информация</h5>
        </div>
        <div class="ibox-content">
            <ul>
                <li>Название: <?= $model->name; ?></li>
                <li>Долговечность: <?= sprintf('%s/%s', $model->duration, $model->maxdur) ?></li>
                <li>Масса: <?= $model->massa ?></li>
                <?php $dategoden = 'без срока' ?>
                <?php if($model->goden): ?>
                <?php
                    $dategoden = sprintf('%s дн.', (new DateTime())->modify('+'.$model->goden.' days')->format('%a'));
                    ?>
                <?php endif; ?>
                <li>Срок годности: <?= $dategoden ?></li>
                <li>Цена кр: <?= $model->cost ?></li>
                <li>Цена екр: <?= $model->ecost ?></li>
                <li>Цена репа: <?= $model->repcost ?></li>
                <li>Категория: <?= $model->razdel ?></li>
                <li>Екр флаг: <?= $model->ekr_flag ?></li>
                <li>Уник флаг: <?= $model->unikflag ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox-title">
            <h5>Встройка</h5>
        </div>
        <div class="ibox-content">
            <?php if(!$model->includemagic): ?>
                <i>Магия отсутствует</i>
            <?php else: ?>
                <ul>
                    <li>Название: <?= $model->include_magic_model->name ?></li>
                    <li>Шанс: <?= $model->include_magic_model->chanse ?></li>
                    <li>Встраивается: <?= $model->include_magic_model->img ? 'Да' : 'Нет'; ?></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox-title">
            <h5>Магия</h5>
        </div>
        <div class="ibox-content">
            <?php if(!$model->magic_model): ?>
                <i>Магия отсутствует</i>
            <?php else: ?>
                <ul>
                    <li>Название: <?= $model->magic_model->name ?></li>
                    <li>Шанс: <?= $model->magic_model->chanse ?></li>
                    <li>Встраиваеся: <?= $model->magic_model->img ? 'Да' : 'Нет'; ?></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox-title">
            <h5>Требования</h5>
        </div>
        <div class="ibox-content">
            <div class="col-lg-6">
                <ul>
                    <li>Уровень: <?= $model->nlovk ?></li>
                    <li>Склонность: <?= $model->nalign ?></li>
                    <li>Пол: <?= $model->nsex ?></li>
                    <li class="separate"></li>
                    <li>Сила: <?= $model->nsila ?></li>
                    <li>Ловкость: <?= $model->nlovk ?></li>
                    <li>Интуиция: <?= $model->ninta ?></li>
                    <li>Выносливость: <?= $model->nvinos ?></li>
                    <li>Интеллект: <?= $model->nintel ?></li>
                    <li>Мудрость: <?= $model->nmudra ?></li>
                </ul>
            </div>
            <div class="col-lg-6">
                <ul>
                    <li>Владение ножами: <?= $model->nnoj ?></li>
                    <li>Владение меами: <?= $model->nmech ?></li>
                    <li>Владение дубинами: <?= $model->ndubina ?></li>
                    <li>Владение топорами: <?= $model->ntopor ?></li>
                    <li>Магия света: <?= $model->nlight ?></li>
                    <li>Магия тьмы: <?= $model->ndark ?></li>
                    <li>Магия серая: <?= $model->ngray ?></li>
                    <li>Магия воды: <?= $model->nwater ?></li>
                    <li>Магия огня: <?= $model->nfire ?></li>
                    <li>Магия земли: <?= $model->nearth ?></li>
                    <li>Магия воздуха: <?= $model->nair ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox-title">
            <h5>Действует на</h5>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-6">
                    <ul>
                        <li>Минимальнй урон: <?= $model->minu ?></li>
                        <li>Максимальный урон: <?= $model->maxu ?></li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul>
                        <li>Аб мф: <?= $model->ab_mf ?>%</li>
                        <li>Аб бронь: <?= $model->ab_bron ?>%</li>
                        <li>Аб урон: <?= $model->ab_uron ?>%</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <ul>
                        <li>Сила: <?= $model->gsila ?></li>
                        <li>Ловкость: <?= $model->glovk ?></li>
                        <li>Интуиция: <?= $model->ginta ?></li>
                        <li>Интеллект: <?= $model->gintel ?></li>
                        <li class="separate"></li>
                        <li>Уровень жизни: <?= $model->ghp ?></li>
                        <li>Уровень маны: <?= $model->gmp ?></li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul>
                        <li>Владение ножами: <?= $model->gnoj ?></li>
                        <li>Владение меами: <?= $model->gmech ?></li>
                        <li>Владение дубинами: <?= $model->gdubina ?></li>
                        <li>Владение топорами: <?= $model->gtopor ?></li>
                        <li>Магия света: <?= $model->glight ?></li>
                        <li>Магия тьмы: <?= $model->gdark ?></li>
                        <li>Магия серая: <?= $model->ggray ?></li>
                        <li>Магия воды: <?= $model->gwater ?></li>
                        <li>Магия огня: <?= $model->gfire ?></li>
                        <li>Магия земли: <?= $model->gearth ?></li>
                        <li>Магия воздуха: <?= $model->gair ?></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <ul>
                        <li>Крит: <?= $model->mfkrit ?>%</li>
                        <li>Против крита: <?= $model->mfakrit ?>%</li>
                        <li>Уворот: <?= $model->mfuvorot ?>%</li>
                        <li>Против уворота: <?= $model->mfauvorot ?>%</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <ul>
                        <li>Броня головы: <?= $model->bron1 ?></li>
                        <li>Броня корпуса: <?= $model->bron2 ?></li>
                        <li>Броня пояса: <?= $model->bron3 ?></li>
                        <li>Броня ног: <?= $model->bron4 ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>