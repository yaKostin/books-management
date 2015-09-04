<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

<?php
	yii\bootstrap\Modal::begin([
		'headerOptions' => ['id' => 'modalHeader'],
		'id' => 'modal',
		'size' => 'modal-lg',
	]);
	echo "<div id='modalContent'></div>";
	yii\bootstrap\Modal::end();
?>

<div class="books-default-index">
    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        'export' => false,
        'pjax' => true,
        'columns' => $gridColumns,
        'responsive'=>true,
        'hover'=>true
        ]);
    ?>
</div>

<?php 
$js = <<< JS
	$(function(){
      	$(document).on('click', '.showModalButton', function(){
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
            	.load($(this).attr('value'));
            document.getElementById('modalHeader').innerHTML = '<h3>' + $(this).attr('title') + '</h3>';
        } else {
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            //dynamiclly set the header for the modal
            document.getElementById('modalHeader').innerHTML = '<h3>' + $(this).attr('title') + '</h3>';
        }
    });
});
JS;
$this->registerJs($js);
?>
