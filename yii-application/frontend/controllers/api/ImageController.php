<?php

namespace frontend\controllers\api;

use common\models\Collection;
use common\models\Image;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;

class ImageController extends ActiveController
{
    public $modelClass = Image::class;

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
            $actions['delete'],
            $actions['view'],
            $actions['update'],
        );

        return $actions;
    }

    public function actionIndex()
    {
        $collectionsIds = Collection::find()->where(['user_id' => Yii::$app->user->id])->select('id')->column();

        if (!$collectionsIds) {
            throw new \yii\web\NotFoundHttpException();
        }

        $images = Image::findAll(['collection_id' => $collectionsIds]);

        if (count($images) < 1) {
            throw new \yii\web\NotFoundHttpException();
        }

        return $images;
    }

    public function actionView($id)
    {
        $image = Image::findOne($id);

        if (!$image) {
            throw new \yii\web\NotFoundHttpException();
        }

        $collection = $image->getCollection()->one();

        if ($collection->user_id !== Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('You are unauthorized to access the requested resource.');
        }

        return $image;
    }

    public function actionDelete($id)
    {
        $image = Image::findOne($id);

        if (!$image) {
            throw new \yii\web\NotFoundHttpException();
        }

        $collection = $image->getCollection()->one();

        if ($collection->user_id !== Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('You are unauthorized to access the requested resource.');
        }

        $image->delete();

        return $image;
    }

    public function actionUpdate($id)
    {
        $image = Image::findOne($id);

        if (!$image) {
            throw new \yii\web\NotFoundHttpException();
        }

        $collection = $image->getCollection()->one();

        if ($collection->user_id !== Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('You are unauthorized to access the requested resource.');
        }
        
        if ($image->load(Yii::$app->request->post()) && $image->save()) {
            return $image;
        } else {
            throw new \yii\web\ServerErrorHttpException();
        }
    }
}
