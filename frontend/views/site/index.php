<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Нажмите на кнопку ниже и увидите таблицу книг</h2>

        <p><a class="btn btn-lg btn-success" href= <?= Url::toRoute("/books") ?> >Перейти к книгам</a></p>
    </div>

    <div class="body-content">

    </div>
</div>
