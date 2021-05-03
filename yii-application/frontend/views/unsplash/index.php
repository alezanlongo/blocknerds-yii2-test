<?php

use yii\web\View;

$this->title = 'Search';
$this->registerJsVar('collections', $collections, View::POS_END);
$this->registerJsFile(
    Yii::$app->request->BaseUrl . '/js/unsplashIndex.js',
    [
        'depends' => "yii\web\JqueryAsset",
        'position' => View::POS_END
    ]
);
?>
<div>
    <div class="search-box">
        <div class="form-inline">
            <input type="text" value="" name="search" , id="search" class="form-control" autocomplete="off">
            <button onclick="search()" class="btn btn-primary">Search</button>
        </div>
    </div>

    <div class="list-box">
        <div id="gallery"></div>
    </div>
</div>
