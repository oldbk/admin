<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;
use \common\models\QuestCondition;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\ConfigKoMain */

\frontend\assets\plugins\ICheckAsset::register($this);
\frontend\assets\plugins\PeityAsset::register($this);
\frontend\assets\plugins\LaddaAsset::register($this);
\frontend\assets\plugins\SweetAlertAsset::register($this);
$quest_id = $model->id;
?>
<style>
    #ko-settings-block .ajax-loader {
        margin-top: 0;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Квест: <?= Html::encode($model->title) ?></h5>
            </div>
            <div class="ibox-content">
                <?php $attributes  = [
                    'id',
                    'title',
                    [
						'attribute' => 'is_enabled',
						'format' => 'raw',
						'value' => $model->is_enabled ? '<span class="label label-success">Да</span>'
							: '<span class="label label-danger">Нет</span>'
                    ]
                ];
                ?>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes,
                ]) ?>

                <p>
                    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('Вернуться', ['/ko/config/index'], ['class' => 'btn btn-default']) ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="ko-config-index">
    <p>
        <?= Html::a('Добавить настройки', ['/ko/settings/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
</div>
<div id="ko-settings-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Список групп настроек</h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin([
                'id' => 'ko-settings-grid',
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
    $(function(){
        getSettings(1);
    });

    function getSettings(page)
    {
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/ko/settings/list', 'id' => $model->id]) ?>'+'&page='+page,
            success: function (response) {
                $('#ko-settings-block .placeholder').html(response);
            }
        });
    }

</script>
