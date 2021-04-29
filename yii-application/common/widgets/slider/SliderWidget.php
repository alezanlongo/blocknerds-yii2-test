<?php

namespace common\widgets\slider;

use yii\base\Widget;
use yii\helpers\Html;

class SliderWidget extends Widget
{
    public $message  = 'You don\'t have images to show!';
    public $items = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if (count($this->items) === 0) {
            return "<h1>" . Html::encode($this->message) . "</h1>";
        } else {
            SliderWidgetAsset::register($this->getView());
            return $this->render('_slider', ['items' => $this->items]);
        }
    }
}
