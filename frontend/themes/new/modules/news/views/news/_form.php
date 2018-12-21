<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\News */
/* @var $form yii\widgets\ActiveForm */

\frontend\assets\plugins\CKEditorAsset::register($this);
\frontend\assets\plugins\DateTimePickerAsset::register($this);
\frontend\assets\plugins\SwitcheryAsset::register($this);
?>
<style>
    .note-editor {
        border: 1px solid #e5e6e7;
        min-height: 300px;
    }
</style>
<div class="news-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-news',
        'layout' => 'horizontal',
        'enableClientValidation' => false,
        'enableClientScript' => false,
        'validateOnSubmit' => false,
    ]); ?>

    <?= $form->field($model, 'topic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput(['class' => 'datetime form-control']) ?>

    <?= $form->field($model, 'is_enabled')->checkbox(['class' => 'js-switch']) ?>

    <?= $form->field($model, 'text')->textarea(['class' => 'summernote']) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Предпросмотр', ['/news/news/preview'], ['class' => 'btn btn-default', 'id' => 'preview']) ?>
        <?= Html::a('Вернуться', ['/news/news/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(function(){
        CKEDITOR.replace( 'news-text', {
            'enterMode' :  CKEDITOR.ENTER_BR
        } );

        $('.datetime').datetimepicker({
            format: 'DD.MM.YY HH:mm'
        });

        $(document.body).on('click', '#preview', function(e){
            e.preventDefault();
            var $self = $(this);

            var data = {
                'title' : $('[name="News[topic]"]').val(),
                'text' : CKEDITOR.instances['news-text'].getData(),
                'date' : $('[name="News[date]"]').val()
            };
            var triggers = {
                'success' : 'news:preview:success'
            };
            $ajax.json($self.prop('href'), data, 'post', triggers);
        });

        $(window).on('news:preview:success', function(e, response) {
            window.open("<?= \yii\helpers\Url::to(['/news/news/empty']) ?>", "_blank", '')
                .document.write(response.content);
        });

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { color: '#1AB394' });
        });
    });
</script>