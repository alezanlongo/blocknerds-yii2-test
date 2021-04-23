<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'UnSplash';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1>Search in UnSplash:</h1>

<div class="unsplash-search">

    <?= Html::beginForm('/unsplash/show', 'POST'); ?>
    <?= Html::textInput('term'); ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?= Html::endForm(); ?>

</div>