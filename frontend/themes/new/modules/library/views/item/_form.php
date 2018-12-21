<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryPocket */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
\frontend\assets\plugins\Select2Asset::register($this);
\frontend\assets\plugins\TouchspinAsset::register($this);

?>

<div class="quest-part-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-item',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'enableClientScript' => false,
        'validateOnSubmit' => false,
    ]); ?>

    <?php if($model->isNewRecord): ?>
        <?= $form->field($model, 'shop_id')->dropDownList($shopList) ?>
        <?= $form->field($model, 'item_id')->dropDownList([], ['class' => 'select2_autocomplete','style' => 'width:100%;']) ?>
    <?php else: ?>
        <?= $form->field($model, 'item_info_name')->textInput(['class' => 'form-control', 'disabled' => true]) ?>
    <?php endif; ?>


    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', Yii::$app->request->getReferrer(), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>
    $(function(){
        $(".select2_autocomplete").select2({
            ajax: {
                url: '<?= \yii\helpers\Url::to(['/item/item/search']) ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        shop_id: $('#libraryitem-shop_id').val()
                    };
                },
                processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 4,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });
    });

    function formatRepo(state) {
        if (!state.id) { return state.text; }

        return buildName(state);
    }

    function formatRepoSelection(data, container) {

        return buildName(data);
    }

    function buildName(data)
    {
        var name = data.name;
        if(data.dur !== undefined && data.maxdur !== undefined) {
            name += ' (' + data.dur + '/' + data.maxdur + ')';
        }
        if(data.id !== undefined) {
           name += ' (' + data.id + ')';
        }
        if(data.cost !== undefined && data.cost > 0) {
            name += ' ' + data.cost + 'кр.';
        }
        if(data.ecost !== undefined && data.ecost > 0) {
            name += ' ' + data.ecost + 'екр.';
        }
        return name;
    }
</script>