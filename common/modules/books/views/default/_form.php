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

    <?= $form->field($model, 'date_create')->textInput(['readonly' => true, 
        'value' => Yii::$app->formatter->asDateTime($model->date_create)]) ?>

    <?= $form->field($model, 'date_update')->textInput(['readonly' => true, 
        'value' => $model->date_update == '0000-00-00 00:00:00' ? 'не изменялась' : 
            Yii::$app->formatter->asDateTime($model->date_update)
        ]) ?>

    <?= $form->field($model, 'preview')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'author_id')->textInput()->dropDownList($authorsArray) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ?
            'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
