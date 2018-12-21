<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\oldbk\LibraryPage */

$this->title = 'Информация о картинках: ' . $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Информация о картинках', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>

<style>
.imgshadow {
	width: 100px;
	float:left;
	padding: 5px;
}
.imagesgrid {
	display:flow-root;
}
</style>

<div class="quest-list-index">
	<?= Html::a('Вернуться', ['index'], ['class' => 'btn btn-success']) ?>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
	    <form method="POST" id="pimages">
            <div class="ibox-title">
                <h5>Личные образы</h5>
            </div>
            <div class="ibox-content imagesgrid">
		<?= ListView::widget([
			'dataProvider' => $shadows,
			'itemView' => '_list',
			'summary' => 'Показано {count} из {totalCount}',
			'emptyText' => '<p>Список пуст</p>',
		    ]); ?>
            </div>

            <div class="ibox-title">
                <h5>Личные подарки</h5>
            </div>
            <div class="ibox-content imagesgrid">
		<?= ListView::widget([
			'dataProvider' => $gifts,
			'itemView' => '_listg',
			'summary' => 'Показано {count} из {totalCount}',
			'emptyText' => '<p>Список пуст</p>',
		    ]); ?>
            </div>

            <div class="ibox-title">
                <h5>Личные картинки</h5>
            </div>
	    <div class="ibox-content imagesgrid">
		<table class="table table-striped">
		<?php 
		foreach($images as $k => $v) {
			?>
			<tr><td><strong><?=$k?></strong></td><td>
			<?php 
			foreach($v as $model) {
				?>

				<div class="imgshadow">
					<?= Html::checkbox('images[]', false,['value' => $model['id']]);?>
					<img src="http://i.oldbk.com/i/sh/<?=$model['img']; ?>" title="" alt="">
				</div>

				<?php
			}
			?>				
			</td></tr>
		<?php
		}
		?>
		</table>
	    </div>

	    <?= Html::button('Удалить выбранное?', [
			'class' => 'btn btn-success',
			'id' => 'delbutton',
		]) ?>

	    </form>
        </div>
    </div>
</div>
<script>
$(function(){
	$(document.body).on('click', '#delbutton', function(){
		var images = 0;	
		var gifts = 0;
		var shadows = 0;

       		$('[name="images[]"]').each( function (){
            		if($(this).prop('checked') == true){
				images++;
            		}
        	});

       		$('[name="gifts[]"]').each( function (){
            		if($(this).prop('checked') == true){
				gifts++;
            		}
        	});

       		$('[name="shadows[]"]').each( function (){
            		if($(this).prop('checked') == true){
				shadows++;
            		}
        	});

		if (!shadows && !gifts && !images) {
			alert("Ничего не выбрано для удаления");
			return;
		} else {
			var msg = "Вы уверен, что хотите удалить ";
			if (shadows > 0) msg += 'образов: '+shadows+', ';
			if (gifts > 0) msg += 'подарков: '+gifts+', ';
			if (images > 0) msg += 'картинок: '+images+', ';
			alert(msg);
		}
	});
});
</script>