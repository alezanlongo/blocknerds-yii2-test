<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Carousel;
use yii\bootstrap4\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1 class="lead">This is your collection Carousel.</h1>
    </div>

    <div class="body-content">
        <?= Carousel::widget([
            'items' => $collection
        ]); ?>
    </div>
</div>