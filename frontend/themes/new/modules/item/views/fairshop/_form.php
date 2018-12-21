<?php

use yii\bootstrap\ActiveForm;
use \common\helper\CategoryDressroomHelper;
use yii\bootstrap\Html;
use common\helper\ShopHelper;


/**
 * Created by PhpStorm.
 * User: me
 * Date: 14.06.17
 * Time: 13:50
 *
 * @var \common\models\oldbk\DressroomItems $model
 */ ?>

<?php $form = ActiveForm::begin([
	'layout' => 'horizontal',
	'enableClientValidation' => false,
	'fieldConfig' => [
		'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>"
	]
]); ?>
<div data-js="modal-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-title">

            </div>
            <div class="ibox-content">
				<?= $form->field($model, 'category_id')->dropDownList(CategoryDressroomHelper::getLabels()) ?>
				<?= $form->field($model, 'dressroom_shop_id')->dropDownList(ShopHelper::getShopList()) ?>
				<?= $form->field($model, 'is_active')->checkbox(['class' => 'js-switch']) ?>
                <fieldset>
                    <legend>Стартовые улучшения</legend>
					<?= $form->field($model, 'is_mf')->checkbox(['class' => 'js-switch']) ?>
					<?= $form->field($model, 'is_unik')->checkbox(['class' => 'js-switch']) ?>
					<?= $form->field($model, 'is_uunik')->checkbox(['class' => 'js-switch']) ?>
                </fieldset>

                <fieldset>
                    <legend>Разрешенные улучшения</legend>
					<?= $form->field($model, 'can_mf')->checkbox(['class' => 'js-switch']) ?>
					<?= $form->field($model, 'can_podgon')->checkbox(['class' => 'js-switch']) ?>
					<?= $form->field($model, 'can_u')->checkbox(['class' => 'js-switch']) ?>
					<?= $form->field($model, 'can_uu')->checkbox(['class' => 'js-switch']) ?>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
	<?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
</div>
<?php ActiveForm::end(); ?>

<script>
    $(function() {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });
    });
</script>
