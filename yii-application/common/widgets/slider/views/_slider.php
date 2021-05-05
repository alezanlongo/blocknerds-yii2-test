<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;

?>
<div>
    <div id="wrap" class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="controls-carousel">
                    <a class="carousel-fullscreen" href="#carousel" role="button">
                        <span class="carousel-fullscreen-icon" aria-hidden="true"></span>
                        <span class="sr-only">Fullscreen</span>
                    </a>
                    <a class="carousel-pause pause" href="#carousel" role="button">
                        <span class="carousel-pause-icon" aria-hidden="true"></span>
                        <span class="sr-only">Pause</span>
                    </a>
                </div>
                <!-- Carousel -->
                <div id="carousel" class="carousel slide gallery" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($items as $key => $item) { ?>
                            <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>" data-slide-number="0" data-toggle="lightbox" data-gallery="gallery">
                                <img src="<?= $item->url ?>" class="d-block w-100" alt="img" height="700" width="900" data-img="<?= ($key + 1) ?>">
                            </div>
                        <?php } ?>

                    </div>
                    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                <!-- The Modal/Lightbox -->
                <div id="myModal" class="modal">
                    <span class="close cursor" onclick="closeModal()">&times;</span>
                    <div class="modal-content">
                        <?php
                        $i = count($items);
                        foreach ($items as $key => $item) {
                        ?>
                            <div class="mySlides">
                                <div class="numbertext"><?= ($key + 1) . '/' . $i ?></div>
                                <?= Html::img($item->url, ['style' => 'width:100%;overflow: hidden;', 'alt' => $item->description]) ?>
                            </div>
                        <?php
                        }
                        ?>
                        <!-- Next/previous controls -->
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                        <!-- Caption text -->
                        <div class="caption-container">
                            <p id="caption"></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>