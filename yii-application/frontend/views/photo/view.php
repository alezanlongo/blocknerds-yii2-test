<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Photo */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => 'Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>
<div class="photo-view">

    <h1><?= Html::encode($model->title) ?></h1>

    <p>
    <?= Html::a(Yii::t('app', '< Back to collection'), ['collection/view', 'id' => $model->collection_id], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app', 'Download'), ['file/download-photo', 'photoId' => $model->id], ['class' => 'btn btn-success']) ?>
        
    </p>


    <div class="card mb-3">
        <div class="row no-gutters">
            <div class="col-md-5">
                <?= Html::a('<img src="' . $model->url . '" alt="img">', $model->url, $options = ["target" => "_blank"]) ?>
            </div>
            <div class="col-md-5">
                <div class="card-body">
                    <h5 class="card-title"><?= $model->title ?></h5>
                    <p class="card-text"><?= $model->description ?></p>
                    <p class="card-text"><small class="text-muted">Last udpated <?= Yii::$app->formatter->asDatetime($model->updated_at)  ?></small></p>
                </div>
            </div>
        </div>
    </div>
</div>