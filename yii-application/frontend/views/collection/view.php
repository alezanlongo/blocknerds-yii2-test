<?php

use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Collection */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="collection-view">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            // 'user_id',
            [
                'attribute' =>   'image',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(BaseStringHelper::truncate($model->image, 99, '...'), $model->image, ['target' => 'blank']);
                },
            ],
            [
                'attribute' =>   'image',
                'format' => 'raw',
                'label' => 'Image',
                'value' => function ($model) {
                    return Html::img($model->image, ['class' => 'img-responsive']);
                },
            ],
            'title',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>