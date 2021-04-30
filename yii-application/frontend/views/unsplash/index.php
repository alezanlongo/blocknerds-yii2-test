<?php
/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

$this->title = 'Result';
$this->params['breadcrumbs'][] = ['label' => 'UnSplash', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>UnSplash result for: <?= $term ?></h1>

<div class="row">
    <?php

    if (isset($unsplash['results'])) {
        foreach ($unsplash['results'] as $item) {
    ?>
            <div class="col-md-3">
                <div class="card">
                    <img src="<?= $item['urls']["thumb"] ?>" class="card-mg-top" width="100%" />
                    <div class="card-body">
                        <h5 class="card-title"><?= $item['description'] ?></h5>
                        <?= Html::hiddenInput('author_' . $item['id'], substr($item['user']['name'], 0, 255)); ?>
                        <?= Html::hiddenInput('title_' . $item['id'], trim($item['description']) == "" ? "Unknown" : substr($item['description'], 0, 255)); ?>
                        <?= Html::hiddenInput('url_' . $item['id'], substr($item['urls']['small'], 0, 255)); ?>
                        <a href="#" class="card-link add_to_collection" data-toggle='modal' data-target='#modal_collection' data-unsplash-id='<?= $item['id']; ?>'>Add to collection</a>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>

<?
Modal::begin([
    'id' => 'modal_collection',
    'title' => '<h2>Where to save the picture</h2>',
    'size' => 'modal-lg',
    'footer' => '<a href="#" class="btn btn-primary save_to_collection" role="button">Save</a>',
]);

echo Html::hiddenInput('unsplash_id', null);
echo Html::activeDropDownList($collection, 'id', $collections);

Modal::end();
?>