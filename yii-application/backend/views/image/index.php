<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\BaseStringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('< Back to collections', ['@web/collection/', 'CollectionSearch[user_id]' => $user_id]) ?>
        <?= Html::a('Create Image', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'collection_id',
            'author',
            'description',
            [
                'attribute' =>   'url',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(BaseStringHelper::truncate($model->url, 35, '...'), $model->url, ['target' => 'blank']);
                },
            ],
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'image' => function ($url, $model) {
                        return Html::a('<i class="fa fa-folder-open"></i>', $url, [
                            'title' => Yii::t('app', 'image')
                        ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'view')
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-edit"></i>', $url, [
                            'title' => Yii::t('app', 'edit')
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title' => Yii::t('app', 'delete'),
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this collection and images?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
            ]
        ],
    ]); ?>


</div>