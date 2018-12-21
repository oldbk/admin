<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \common\helper\CurrencyHelper;

/* @var $this yii\web\View */
/* @var $model common\models\loto\LotoItem */
/* @var $item common\models\itemInfo\CustomItemInfo */
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

    <div class="summary">
        <?= $form->errorSummary($model); ?>
    </div>

    <div class="field-lotoitem-cost required">
        <label class="control-label col-sm-3" for="lotoitem-cost">Цена</label>
        <div class="col-sm-6">
            <div class="col-sm-2" style="margin-right: 5px;">
                <?= $form->field($model, 'cost', ['template' => "{input}\n{error}"])
                    ->textInput(['maxlength' => true])->label(false) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'cost_type', ['template' => "{input}\n{error}"])
                    ->dropDownList(CurrencyHelper::getCurrency())->label(false) ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'stock')->checkbox(['class' => 'js-switch']) ?>
    <?= $form->field($model, 'category_id')->dropDownList(\common\helper\CategoryHelper::getLabels()) ?>

    <?php if($model->isNewRecord): ?>
        <?= $form->field($item, 'item_id')->dropDownList([], ['class' => 'select2_autocomplete','style' => 'width:100%;']) ?>
    <?php else: ?>
        <?= $form->field($model, 'item_info_name')->textInput(['class' => 'form-control', 'disabled' => true]) ?>
    <?php endif; ?>
    <?= $form->field($model, 'count')->textInput(['class' => 'form-control touchspin1']) ?>
    <?= $form->field($model, 'item_count')->textInput(['class' => 'form-control touchspin1']) ?>

    <?= $form->field($item, 'other_settings')->checkbox(['class' => 'js-switch']) ?>

    <div style="display: none" id="other-settings">
        <?= $form->field($item, 'goden')->textInput(['class' => 'form-control touchspin1', 'data-postfix' => 'дн.']) ?>
        <?= $form->field($item, 'ekr_flag')->textInput(['class' => 'form-control touchspin1']) ?>
    </div>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Вернуться', ['/loto/pocket/view', 'id' => $model->pocket_id], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(function(){
        if($('#customiteminfo-other_settings').is(':checked')) {
            $('#other-settings').show();
        }

        $('#customiteminfo-other_settings').on('change', function(){
            if($(this).prop('checked')) {
                $('#other-settings').show();
            } else {
                $('#other-settings').hide();
            }
        });

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

        $(".select2_autocomplete").select2({
            ajax: {
                url: '<?= \yii\helpers\Url::to(['/item/item/custom-search']) ?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
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
        if(data.id !== undefined) {
           name += ' (' + data.id + ')';
        }
        return name;
    }
</script>