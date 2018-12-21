<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\helper\CurrencyHelper;

/* @var $this yii\web\View */
/* @var $model \common\models\QuestPocketItem */
/* @var $item common\models\itemInfo\ItemInfo */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
\frontend\assets\plugins\Select2Asset::register($this);
\frontend\assets\plugins\TouchspinAsset::register($this);
?>

<div class="loto-item-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'fieldConfig' => [
            'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>"
        ]
    ]); ?>

    <?= $form->errorSummary($model); ?>

    
    <?php if($model->isNewRecord): ?>
        <?= $form->field($item, 'shop_id')->dropDownList(\common\helper\ShopHelper::getShopList()) ?>
        <?= $form->field($item, 'item_id')->dropDownList([], ['class' => 'select2_autocomplete','style' => 'width:100%;']) ?>
        <?= $form->field($item, 'item_ids')->textInput(['placeholder' => 'Если нужно несколько предметов, сюда через запятую']) ?>
    <?php else: ?>

    <?php endif; ?>
    <?= $form->field($model, 'count')->textInput(['class' => 'form-control touchspin1']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/quest/part/view', 'id' => $model->pocket_item_id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        if($('#iteminfo-other_settings').is(':checked')) {
            $('#other-settings').show();
        }

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });

        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999,
            boostat: 5,
            maxboostedstep: 10
        });

        $('#iteminfo-other_settings').on('change', function(){
            if($(this).prop('checked')) {
                $('#other-settings').show();
            } else {
                $('#other-settings').hide();
            }
        });

        $(".select2_autocomplete").select2({
            ajax: {
                url: '<?= \yii\helpers\Url::to(['/item/item/search']) ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        shop_id: $('#iteminfo-shop_id').val()
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
            minimumInputLength: 2,
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