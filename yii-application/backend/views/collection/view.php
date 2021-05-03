<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Collection */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Collections', 'url' => ['index', "userId"=> $model->user_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>
<div class="collection-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p class="card-text"><small class="text-muted">Created: <?= Yii::$app->formatter->asDatetime($model->created_at)  ?></small></p>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <div class="card-columns">
        <?php foreach ($model->getPhotos()->asArray()->all() as $photo) { ?>
            <div class="card">
                <img class="card-img-top img-fluid" src="<?= $photo["url"] ?>" alt="image">
                <div class="card-block">
                    <h4 class="card-title"><?= $photo["title"] ?></h4>
                    <p class="card-text"><?= $photo["description"] ?></p>
                    <div>
                        <?= Html::a(Yii::t('app', 'Show'), ['photo/view', "id" => $photo['id']]) ?>
                        <p class="card-text"><small class="text-muted">Created: <?= Yii::$app->formatter->asDatetime($photo["created_at"])  ?></small></p>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>

</div>
