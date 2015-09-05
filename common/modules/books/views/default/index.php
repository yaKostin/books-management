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

<?php Pjax::begin(['id' => 'search-form-pjax']) ?>

	<?php $form = ActiveForm::begin(
		[
			'action' => Url::canonical(),
			'method' => 'get',
			'options' => ['data-pjax' => true ],
		])
	?>

		<div>
			<div class="row">
				<div class="col-md-3">
					<?= $form->field($searchModel, 'author_id')
							->dropDownList($authorsArray, ['prompt' => 'Автор'])
							->label(false);
					?>
				</div>
				<div class="col-md-3">
					<?= $form->field($searchModel, 'name')
							->textInput(['placeholder' => 'Название книги'])
							->label(false);
					?>
				</div>
			</div>
			<div class="row">
				
				<div class="col-xs-2">
					<label>Дата выхода книги</label>
				</div>
				<div class="col-md-3">
					<?= $form->field($searchModel, 'date_from')
						->widget(DatePicker::className(), 
							[
						        'inline' => false,
				                'language' => 'ru',
				                'clientOptions' => [
				                	'autoclose' => true,
				                    'format' => 'yyyy-mm-dd',
				                    'clearBtn' => 'true',
				                    'endDate' => date('yyyy-mm-dd'),
				                ],    
							]
						)
						->label(false);
					?>
				</div>

				<div class="col-xs-2 text-right">
					<label>до</label>
				</div>
				<div class="col-md-3">
					<?= $form->field($searchModel, 'date_to')
						->widget(DatePicker::className(),
							[
						        'inline' => false,
				                'language' => 'ru',
				                'clientOptions' => [
				                	'autoclose' => true,
				                    'format' => 'yyyy-mm-dd',
				                    'clearBtn' => 'true',
				                    'endDate' => date('yyyy-mm-dd'),
				                ],    
							]
						)->label(false);
					?>
				</div>

				<div class="col-md-2">
					<?= Html::submitButton('Искать',
							[
								'class' => 'btn btn-primary btn-block',
								'id' => 'searchBtn'
							]
						);
					?>
				</div>
			</div>

		</div>

		<input type="hidden" name="r" value="books">

	<?php ActiveForm::end(); ?>

<?php Pjax::end() ?>

<?php Pjax::begin(['id' => 'books-pjax']) ?>

    <?= GridView::widget(
	    	[
		        'dataProvider' => $dataProvider,
		        'filterModel' => $searchModel,
		        'columns' => $gridColumns,
		        'filterPosition' => false
	        ]
	    );
    ?>
<?php Pjax::end() ?>

</div>

<?php 
$js = <<< JS
	$(function() {
      	$(document).on('click', '.btn-show-modal', function() {
        	if ( $('#modal').data('bs.modal').isShown ) {
	            $('#modal').find('#modalContent')
	            	.load( $(this).data('url') );
	            document.getElementById('modalHeader').innerHTML = '<h3>' + $(this).attr('title') + '</h3>';
        	}
        	else {
	            $('#modal').modal('show')
	                .find('#modalContent')
	                .load( $(this).data('url') );
	            document.getElementById('modalHeader').innerHTML = '<h3>' + $(this).attr('title') + '</h3>';
        	}
    	});

		$(document).on('click', '.btn-delete-book', function() {   
			$.ajax({
				method: "POST",
				url: $(this).data('url'),
			})
			.done(function(data) {
				console.log(data);
				$.pjax.reload({container:"#books-pjax"}); 
			});
    	});

		$(document).on('click', '.btn-update-book', function() {   
			window.location.href = $(this).data('url');
    	});
	});

	$("document").ready(function(){ 
        $("#search-form-pjax").on("pjax:end", function() {
            $.pjax.reload({container:"#books-pjax"}); 
        });
    });
JS;
$this->registerJs($js);
?>
