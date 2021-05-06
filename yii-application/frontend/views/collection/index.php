<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\BaseStringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CollectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Collection', ['collection/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            // 'user_id',
            [
                'attribute' =>   'title',
                'format' => 'raw',
                'value' => function ($model) {
                    return BaseStringHelper::truncate($model->title, 55, '...');
                },
            ],
            // 'created_by',
            // 'updated_by',
            'created_at:datetime',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{images} {view} {update} {delete}',
                'buttons' => [
                    'images' => function ($url, $model) {
                        return Html::a('<i class="fa fa-folder-open"></i>', $url, [
                            'title' => Yii::t('app', 'images')
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
                                'confirm' => 'Are you sure you want to delete this collection and all images?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action == "images") {
                        return Url::to(['@web/image', 'collection_id' => $model->id]);
                    }
                    return Url::to([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>


</div>