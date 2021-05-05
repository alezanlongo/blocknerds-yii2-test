<?php

namespace api\modules\v1\controllers;

use common\models\Collection;
use common\models\CollectionSearch;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;

class CollectionController extends ActiveController
{
    public $modelClass = Collection::class;

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'actionIndex'];

        unset(
            $actions['create'],
            $actions['update'],
            $actions['delete'],
            $actions['view'],
        );

        return $actions;
    }

    public function actionIndex()
    {
        $searchModel = new CollectionSearch();
        $searchModel->user_id = Yii::$app->user->id;
        return $searchModel->search(Yii::$app->request->queryParams);
    }

    public function actionView($id)
    {
        $collection = Collection::findOne($id);

        if ($collection->user_id !== Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('You are unauthorized to access the requested resource.');
        }

        return $collection;
    }

    public function actionDelete($id)
    {
        $collection = Collection::findOne($id);

        if ($collection->user_id !== Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('You are unauthorized to access the requested resource.');
        }

        $collection->delete();

        return $collection;
    }

    public function actionUpdate($id)
    {
        $collection = Collection::findOne($id);

        if ($collection->user_id !== Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('You are unauthorized to access the requested resource.');
        }

        $fields['Collection'] = Yii::$app->request->post();

        if ($collection->load($fields) && $collection->save()) {
            return $collection;
        } else {
            throw new \yii\web\UnprocessableEntityHttpException('Validation problems were found');
        }

        return $collection;
    }

    public function actionCreate()
    {
        $model = new Collection();
        $fields['Collection'] = Yii::$app->request->post();
        $fields['Collection']['user_id'] = Yii::$app->user->identity->getId();

        if ($model->load($fields) && $model->save()) {
            return $model;
        } else {
            throw new \yii\web\UnprocessableEntityHttpException('Validation problems were found');
        }
    }
}
