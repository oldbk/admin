<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\recipe\RecipeItemGive */
/* @var $item \common\models\recipe\give\RecipeGiveItem */
/* @var $recipe \common\models\recipe\Recipe */
/* @var $form yii\bootstrap\ActiveForm */

\frontend\assets\plugins\SwitcheryAsset::register($this);
\frontend\assets\plugins\TouchspinAsset::register($this);
\frontend\assets\plugins\Select2Asset::register($this);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Условие ингредиент</h5>
            </div>
            <div class="ibox-content">
                <div class="dialog-quest-form">

                    <?php $form = ActiveForm::begin([
                        'id' => 'form-pocket',
                        'layout' => 'horizontal',
                        'enableClientValidation' => false,
                        'enableClientScript' => false,
                        'validateOnSubmit' => false,
                    ]); ?>

                    <div class="summary">
                        <?= $form->errorSummary($model); ?>
                    </div>

                    <?php if($model->isNewRecord): ?>
                        <?= $form->field($item, 'shop_id')->dropDownList(\common\helper\ShopHelper::getShopList()) ?>
                        <?= $form->field($item, 'item_id')->dropDownList([], ['class' => 'select2_autocomplete','style' => 'width:100%;']) ?>
                    <?php else: ?>
                        <?= $form->field($item, 'item_name')->textInput(['disabled' => 'disabled']) ?>
                    <?php endif; ?>

                    <?= $form->field($item, 'count')->textInput(['class' => 'form-control touchspin1']) ?>

                    <div class="form-group" style="text-align: center;">
                        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        <?= Html::a('Вернуться', ['/recipe/recipe/view', 'id' => $recipe->id], ['class' => 'btn btn-default']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            max: 99999999999999999999999,
            boostat: 5,
            maxboostedstep: 10
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
                        shop_id: $('#questpocketitem-shop_id').val()
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

        return state.name + ' (' + state.id + ')';
    }

    function formatRepoSelection(data, container) {
        return data.name;
    }
</script>