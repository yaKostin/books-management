<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

<?php yii\bootstrap\Modal::begin(
		[
			'headerOptions' => ['id' => 'modalHeader'],
			'id' => 'modal',
			'size' => 'modal-lg',
		]
	); 
?>
	<div id='modalContent'></div>
<?php yii\bootstrap\Modal::end(); ?>

<div class="books-default-index">

	<?php $form = ActiveForm::begin([
		'action' => Url::canonical(),
		'id' => 'search-form',
		'method' => 'get',
	]) ?>

		<?= $form->field($searchModel, 'name'); ?>

		<?= $form->field($searchModel, 'author_id')
				->dropDownList($authorsArray); 
		?>

		<?= $form->field($searchModel, 'date_from')
			->widget(DatePicker::className(), 
				[
			        'inline' => false,
	                'language' => 'ru',
	                'clientOptions' => [
	                	'autoclose' => true,
	                    'format' => 'yyyy-mm-dd',
	                ],    
				]
			);
		?>

		<?= $form->field($searchModel, 'date_to')
			->widget(DatePicker::className(),
				[
			        'inline' => false,
	                'language' => 'ru',
	                'clientOptions' => [
	                	'autoclose' => true,
	                    'format' => 'yyyy-mm-dd',
	                    'clearBtn' => 'true'
	                ],    
				]
			);
		?>

		<input type="hidden" name="r" value="books">

		<?= Html::submitButton('Искать',
				[
					'class' => 'btn btn-primary',
					'id' => 'searchBtn'
				]
			);
		?>

	<?php ActiveForm::end(); ?>

	<?php Pjax::begin(['id' => 'books']) ?>

	    <?= GridView::widget(
		    	[
			        'dataProvider' => $dataProvider,
			        'filterModel' => $searchModel,
			        'columns' => $gridColumns,
			        'filterPosition' => ''
		        ]
		    );
	    ?>
    <?php Pjax::end() ?>

</div>

<?php 
$js = <<< JS
	$(function() {
      	$(document).on('click', '.showModalButton', function() {
        	if ( $('#modal').data('bs.modal').isShown ) {
	            $('#modal').find('#modalContent')
	            	.load( $(this).attr('value') );
	            document.getElementById('modalHeader').innerHTML = '<h3>' + $(this).attr('title') + '</h3>';
        	}
        	else {
	            $('#modal').modal('show')
	                .find('#modalContent')
	                .load( $(this).attr('value') );
	            document.getElementById('modalHeader').innerHTML = '<h3>' + $(this).attr('title') + '</h3>';
        	}
    	});
	});
JS;
$this->registerJs($js);
?>
