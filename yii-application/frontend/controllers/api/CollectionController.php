<?php

namespace frontend\controllers\api;

use common\models\CollectionSearch;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

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

        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'actionIndex'];

        return $actions;
    }

    public function actionIndex()
    {
        $searchModel = new CollectionSearch();
        $searchModel->user_id = Yii::$app->user->id;
        return $searchModel->search(Yii::$app->request->queryParams);
    }
}
