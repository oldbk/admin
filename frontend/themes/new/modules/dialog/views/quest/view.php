<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\dialog\DialogQuest */

?>

<style>
    #dialog-action-block .ajax-loader {
        margin-top: 0;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Просмотр реплики</h5>
            </div>
            <div class="ibox-content">
                <?php $attributes = [
                    'id',
                    [
                        'attribute' => 'quest.name',
                        'label' => 'Квест'
                    ],
                    [
                        'attribute' => 'bot.name',
                        'label' => 'Бот'
                    ],
                    [
                        'attribute' => 'action_type',
                        'value' => \common\models\dialog\DialogQuest::getActions()[$model->action_type]
                    ],
                    'message:raw',
                    [
                        'attribute' => 'is_saved',
                        'format' => 'raw',
                        'value' => $model->is_saved ? '<span class="label label-success">Да</span>'
                            : '<span class="label label-danger">Нет</span>'
                    ],
                ];
                ?>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => $attributes,
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('Вернуться', ['/quest/quest/view', 'id' => $model->global_parent_id], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
</div>

<div class="quest-part-index">
    <p>
        <?= Html::a('Добавить ответ', ['/dialog/action/create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
</div>

<div id="dialog-action-block">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Список ответов</h5>
        </div>
        <div class="ibox-content">
            <?php Pjax::begin([
                'id' => 'dialog-action-grid',
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
        $.ajax({
            url: '<?= \yii\helpers\Url::to(['/dialog/action/list', 'id' => $model->id]) ?>',
            success: function (response) {
                $('#dialog-action-block .placeholder').html(response);
            }
        });
    });
</script>
