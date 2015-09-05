<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\books\models\Book */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
            'attribute' => 'preview',
                'value' => $model->preview,
                'format' => [
                    'image',
                    [
                        'width' => '120',
                        'height' => '160'
                    ]
                ],
            ],
            'id',
            'name',
            'date_create',
            [
                'attribute' => 'date_update',
                'value' => ($model->date_update == '0000-00-00 00:00:00') ? 'не изменялась' : 
                    Yii::$app->formatter->asDateTime($model->date_update),
            ],
            'date',
            [
                'attribute' => 'author.firstname',
                'label' => 'Автор',
                'value' => $model->author->firstname . " " . $model->author->lastname,
            ],
        ]
    ]) ?>

</div>
