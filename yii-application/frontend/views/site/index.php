<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Carousel;
use yii\bootstrap4\Html;
use yii\web\View;

$this->title = 'Gallery';
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

<h1>Favorites list</h1>
<?php if ($collection) { ?>
    <div id="slider">
        <?= Html::a('<i class="fas fa-arrow-right"></i>', "#", $options = ['class' => "control_next"]) ?>
        <?= Html::a('<i class="fas fa-arrow-left"></i>', "#", $options = ['class' => "control_prev"]) ?>
        <ul>
            <?php foreach ($collection as $photo) { ?>
                <li>
                    <div>
                        <?= Html::a('<img src="' . $photo["url"] . '" alt="img">', $photo["url"], $options = [
                            "class" => "img-slider"
                        ]) ?>
                    </div>
                </li>
            <?php  } ?>
        </ul>
    </div>
    <div class="slider_option">
        <input type="checkbox" id="checkbox">
        <label for="checkbox">Autoplay Slider</label>
    </div>

<?php } ?>
