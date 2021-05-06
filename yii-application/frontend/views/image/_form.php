<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if ($model->isNewRecord) {
        echo $form->field($model, 'collection_id')->textInput();
    }
    ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <div class="form-check">
        <label for="created_at">Created at:</label>
        <?= Yii::$app->formatter->asDate($model->created_at, 'long'); ?>
    </div>

    <div class="form-check">
        <label for="created_at">Updated at:</label>
        <?= Yii::$app->formatter->asDate($model->updated_at, 'long'); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>