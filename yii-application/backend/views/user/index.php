<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',
            'status',
            'created_at:datetime',
            // 'updated_at:datetime',
            //'verification_token',
            'is_admin:boolean',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{collection} {view} {update} {delete}',
                'buttons' => [
                    'collection' => function ($url, $model) {
                        return Html::a('<i class="fa fa-folder-open"></i>', $url, [
                            'title' => Yii::t('app', 'collection')
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
                                'confirm' => 'Are you sure you want to delete this user with all collections ans images ?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action == "collection") {
                        return Url::to(['@web/collection', 'CollectionSearch[user_id]' => $model->id]);
                    }
                    return Url::to([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>


</div>