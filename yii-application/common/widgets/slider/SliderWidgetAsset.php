<?php

namespace common\widgets\slider;

use yii\web\AssetBundle;

class SliderWidgetAsset extends AssetBundle
{
    public $js = [
        'js/sliderwidget.js'
    ];

    public $css = [
        // // CDN lib
        // '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
        'css/sliderwidget.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }
}
