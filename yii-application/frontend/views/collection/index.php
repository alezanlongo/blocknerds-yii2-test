<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\BaseStringHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Collection', ['create'], ['class' => 'btn btn-success']) ?>
        <!-- <?= Html::a(Yii::t('app', 'Download as Zip'), ['file/download-all-favorites'], ['class' => 'btn btn-success']) ?> -->
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'label' => 'Title',
                "format" => "raw",
                'value' => function ($data) {
                    return Html::a(
                        $data->title,
                        [
                            'collection/view', 'id' => $data->id
                        ],
                        [
                            'target' => 'blank'
                        ]
                    );
                },
            ],
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-edit"></i>', $url, [
                            'title' => Yii::t('app', 'edit')
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title' => Yii::t('app', 'delete'),
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fas fa-images"></i>', $url, [
                            'title' => Yii::t('app', 'view')
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

</div>