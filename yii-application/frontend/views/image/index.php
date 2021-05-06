<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\BaseStringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Image', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' =>   'collection_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->collection_id, '@web/collection/view?id=' . $model->collection_id);
                },
            ],
            [
                'attribute' =>   'author',
                'format' => 'raw',
                'value' => function ($model) {
                    return BaseStringHelper::truncate($model->author, 25, '...');
                },
            ],
            [
                'attribute' =>   'description',
                'format' => 'raw',
                'value' => function ($model) {
                    return BaseStringHelper::truncate($model->author, 55, '...');
                },
            ],
            [
                'attribute' =>   'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(BaseStringHelper::truncate($model->url, 35, '...'), $model->url, ['target' => 'blank']);
                },
            ],
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-edit"></i>', $url, [
                            'title' => Yii::t('app', 'edit')
                        ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'view')
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title' => Yii::t('app', 'delete'),
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this image?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>


</div>