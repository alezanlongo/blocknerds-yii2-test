<?php

namespace frontend\controllers\api;

use common\models\Collection;
use common\models\Photo;
use DateTime;
use Error;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;

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
        unset(
            $actions['delete'],
            $actions['create'],
            $actions['update'],
            $actions['index'],
            $actions['view']
        );

        return $actions;
    }

    public function actionIndex()
    {
        return  Yii::$app->user->getIdentity()->collections;
    }


    public function actionView($id)
    {
        return Yii::$app->user->getIdentity()
            ->getCollections()->with("photos")
            ->where(["id" => $id])
            ->asArray()->one();
    }

    public function actionCreate()
    {
        try {
            $data = Yii::$app->request->post();
            $newCollection = new Collection();
            $newCollection->title = $data["title"];
            $newCollection->user_id = Yii::$app->user->id;
            $newCollection->save();
    
            return $newCollection;
        } catch (\Throwable $e) {
            throw new ServerErrorHttpException();
        }
    }

    public function actionUpdate($id)
    {
        $collection = Collection::find()->where([
            'user_id' => Yii::$app->user->id,
            'id' => $id
        ])->one();

        if (!$collection) {
            throw new NotFoundHttpException('Collection not found.');
        }

        $data = Yii::$app->request->post();
        $collection->title = $data["title"];
        
        if(!$collection->validate()){
            throw new UnprocessableEntityHttpException('Invalid data');
        }

        $collection->save();

        return $collection;
    }

    public function actionDelete($id)
    {
        $collection = Collection::find()->where([
            'user_id' => Yii::$app->user->id,
            'id' => $id
        ])->one();

        if (!$collection) {
            throw new NotFoundHttpException('Collection not found.');
        }

        $collection->delete();

        return "collection deleted";
    }
}
