<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\books\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group ">
        <label class="control-label">Дата добавления</label>
        <?= \yii\timeago\TimeAgo::widget(['timestamp' => gmdate("Y-m-d\TH:i:s\Z", strtotime($model->date_create)), 'language' => 'ru']) ?>
    </div>

    <div class="form-group ">
        <label class="control-label">Дата обновления</label>
        <?= \yii\timeago\TimeAgo::widget(['timestamp' => gmdate("Y-m-d\TH:i:s\Z", strtotime($model->date_update)), 'language' => 'ru']) ?>
    </div>

    <?= $form->field($model, 'preview')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'author_id')->textInput()->dropDownList($authorsArray) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ?
            'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
