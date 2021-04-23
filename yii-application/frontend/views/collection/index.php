<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\BaseStringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CollectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Collections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add image to collection', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Download collection', ['download'], ['class' => 'btn btn-default']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'user_id',
            [
                'attribute' =>   'image',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(BaseStringHelper::truncate($model->image, 55, '...'), $model->image, ['target' => 'blank']);
                },
            ],
            [
                'attribute' =>   'title',
                'format' => 'raw',
                'value' => function ($model) {
                    return BaseStringHelper::truncate($model->title, 25, '...');
                },
            ],
            'created_at:datetime',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>