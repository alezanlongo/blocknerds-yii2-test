<?php

use yii\helpers\Html;
?>

<div>
    <!-- Images used to open the lightbox -->
    <div class="row">
        <?php
        $i = 1;
        foreach ($items as $item) {
        ?>
            <div class="column">
                <?= Html::img($item->url, ['alt' => $item->description, 'class' => 'hover-shadow', 'onclick' => 'openModal();currentSlide(' . $i . ')']) ?>
            </div>
        <?php
            $i++;
        }
        ?>
    </div>

    <!-- The Modal/Lightbox -->
    <div id="myModal" class="modal">
        <span class="close cursor" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <?php
            $a = 1;
            foreach ($items as $item) {
            ?>
                <div class="mySlides">
                    <div class="numbertext"><?= $a . '/' . $i ?></div>
                    <?= Html::img($item->url, ['style' => 'width:100%', 'alt' => $item->description]) ?>
                </div>
            <?php
                $a++;
            }
            ?>

            <!-- Next/previous controls -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            <!-- Caption text -->
            <div class="caption-container">
                <p id="caption">
                <div class="slider_option">
                    <input type="checkbox" id="checkbox">
                    <label for="checkbox">Autoplay Slider</label>
                </div>
                </p>
            </div>
        </div>
    </div>
</div>