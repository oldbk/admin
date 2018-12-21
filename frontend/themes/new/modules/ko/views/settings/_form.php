<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\oldbk\ConfigKoSettings;

/* @var $this yii\web\View */
/* @var $model common\models\Quest */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $isNewRecord boolean */

\frontend\assets\plugins\DateTimePickerAsset::register($this);
\frontend\assets\plugins\LaddaAsset::register($this);
?>
<style>
	.level {
		width: 200px;
	}
	.help-block {
		font-style: italic;
	}
    .config-fields.form-group {
        width: 1000px;
        margin: 0 auto;
        margin-bottom: 15px;
    }
</style>
<div id="quest-condition-block">
	<div class="ibox">
		<div class="ibox-title">
			<h5>Добавить поле</h5>
		</div>
		<div class="ibox-content">
            <form class="form-horizontal">
                <div class="form-group field-config-field_type">
                    <label class="control-label col-sm-3" for="config-field_type">Тип поля</label>
                    <div class="col-sm-2">
                        <select id="config-field_type" class="form-control" name="Config[field_type]">
                            <option value="<?= ConfigKoSettings::TYPE_DATETIMEPICKER ?>">Дата</option>
                            <option value="<?= ConfigKoSettings::TYPE_STRING ?>">Строка</option>
                            <option value="<?= ConfigKoSettings::TYPE_ARRAY ?>">Массив</option>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <a class="btn btn-sm btn-success" id="add-field" href="javascript:void(0);">+</a>
                    </div>
                </div>
            </form>
		</div>
	</div>
</div>
<div class="ibox">
    <div class="ibox-content">
		<?php $form = ActiveForm::begin([
			'layout' => 'horizontal',
			'enableClientValidation' => false,
			'id' => 'stock',
			'fieldConfig' => [
				'checkboxTemplate' => "<div class=\"checkbox checkbox-primary\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>",
				"template" => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
				'horizontalCssClasses' => [
					'hint' => ''
				]
			]
		]); ?>
        <div id="field-list">

        </div>
        <div class="form-group" style="text-align: center;">
			<?= Html::a($isNewRecord ? 'Создать' : 'Редактировать', 'javascript:void(0)', [
			        'class' => $isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-primary ladda-button',
                    'id' => 'save-form',
                    'data-style' => 'expand-left'
            ]) ?>
			<?= Html::a('Вернуться', ['/ko/config/view', 'id' => $main_id], ['class' => 'btn btn-default']) ?>
        </div>

		<?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    var items = <?= \yii\helpers\Json::encode($items); ?>;
    var $save_btn = $('#save-form');
    $(function(){
        $save_btn.ladda();

        $(document.body).on('click', '#add-field', function() {
            var type = $('#config-field_type').val();

            addRow('', '', type);
        });
        $(document.body).on('click', '.remove-field', function() {
            var $self = $(this);
            $self.closest('.config-fields').remove();
        });
        $(document.body).on('click', '#save-form', function() {
            save();
        });
        $.each(items, function(i, _item) {
           addRow(_item['name'], _item['value'], _item['type']);
        });
    });

    function addRow(name, value, type)
    {
        var number = 0;
        var temp = $('#field-list .config-fields:last');
        if(temp.length > 0) {
            number = parseInt(temp.attr('data-num')) + 1;
        }

        var $wrapp = $('<div>', {'class': 'form-group config-fields', 'data-num': number});
        $('<div>', {'class': 'col-sm-3', 'html': '<input type="text" value="'+name+'" name="Config['+number+'][name]" class="form-control name" maxlength="255" placeholder="Название поля">'}).appendTo($wrapp);
        var $value = $('<div>', {'class': 'col-sm-7', 'html': '<input type="text" value="'+value+'" name="Config['+number+'][value]" class="form-control value" maxlength="255" placeholder="Значение поля">'}).appendTo($wrapp);
        $('<div>', {'class': 'col-sm-1', 'html': '<a class="btn btn-sm btn-danger remove-field" href="javascript:void(0);">-</a>'}).appendTo($wrapp);
        $('<div>', {'class': 'col-sm-1', 'html': '<input type="hidden" value="'+type+'" name="Config['+number+'][type]" class="form-control type" maxlength="255">'}).appendTo($wrapp);

        $wrapp.appendTo('#field-list');

        switch (type) {
            case 'datetimepicker':
                $value.find('input').datetimepicker({
                    format: 'YYYY-MM-DD HH:mm:ss'
                });
                break;
        }
    }

    function save()
    {
        var data = [];
        if($('#field-list .config-fields').length < 1) {
            alert('Вы не добавили поля');
            return;
        }
        var error = false;
        $.each($('#field-list .config-fields'), function(i, el) {
            var $wrapp = $(el);
            var name = $wrapp.find('.name').val().trim();
            if(name.length < 1) {
                alert('Проверьте поля');
                error = true;
                return;
            }

            var type = $wrapp.find('.type').val().trim();
            if(type.length < 1) {
                alert('Проверьте поля');
                error = true;
                return;
            }
            var value = $wrapp.find('.value').val().trim();

            data.push({'name': name, 'value': value, 'type': type});
        });

        if(error == false && data.length > 0) {
            $.ajax({
                data        : {'Config': data},
                dataType    : 'json',
                type        : 'post',
                beforeSend  : function() {
                    $save_btn.ladda('start');
                },
                success: function(response) {
                    if(response.status == 1){
                        window.location.href = response.url;
                    } else {
                        alert(response.message);
                    }
                }
            }).always(function() {
                $save_btn.ladda('stop');
            });
        } else {
            alert('Ошибка');
        }
    }
</script>
