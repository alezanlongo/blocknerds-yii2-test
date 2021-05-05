<?php

/* @var $this yii\web\View */

use common\widgets\slider\SliderWidget;

$this->title = 'Gallery';

?>

<h1>Favorites list</h1>

<?=
SliderWidget::widget([
  'items' => $collection
]); ?>