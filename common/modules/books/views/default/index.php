<?php
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

<script type="text/javascript" src="highslide/highslide.js"></script>
<script type="text/javascript" src="highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />

<div class="books-default-index">
    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        'export' => false,
        'columns' => $gridColumns,
        'responsive'=>true,
        'hover'=>true
        ]);
    ?>
</div>
