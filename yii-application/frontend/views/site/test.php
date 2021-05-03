<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\View;

$this->title = 'Test';
$this->registerCssFile(
    Yii::$app->request->getBaseUrl() . '/css/slider.css'
);
$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/slider.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
?>
<h1><?= $this->title ?></h1>

<div id="slider">
    <?= Html::a('>', "#", $options = ['class' => "control_next"]) ?>
    <?= Html::a('<', "#", $options = ['class' => "control_prev"]) ?>

    <ul>
        <?php foreach ($photos as $photo) { ?>
            <li>Img test</li>
        <?php  } ?>
    </ul>
</div>

<div class="slider_option">
    <input type="checkbox" id="checkbox">
    <label for="checkbox">Autoplay Slider</label>
</div>