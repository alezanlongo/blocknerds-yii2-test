<?php

use yii\helpers\Html;
?>

<div>
    <div id="slider">
        <a href="#" class="control_next">&gt;</a>
        <a href="#" class="control_prev">&nlt;</a>
        <ul>
            <?php
            foreach ($items as $item) {
            ?>
                <li>
                    <?= Html::img($item->url, ['alt' => $item->description]) ?>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>

    <div class="slider_option">
        <input type="checkbox" id="checkbox">
        <label for="checkbox">Autoplay Slider</label>
    </div>
</div>