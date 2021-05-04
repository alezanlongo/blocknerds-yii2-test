<?php

namespace frontend\controllers\api;

use common\models\Photo;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class PhotoController extends ActiveController
{
    public $modelClass = Photo::class;

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
        $collectionsIds = ArrayHelper::getColumn(Yii::$app->user->getIdentity()->collections,'id');

        if (!$collectionsIds) {
            return [];
        }

        return Photo::findAll(['collection_id' => $collectionsIds]);
    }

    public function actionView($id)
    {
        return $this->getPhoto($id);
    }

    private function getPhoto($id)
    {
        $photo = Photo::findOne($id);

        if (!$photo) {
            throw new NotFoundHttpException('Photo not found.');
        }

        $collection = $photo->getCollection()->one();

        if ($collection->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are unauthorized to access the requested resource.');
        }

        return $photo;
    }

    public function actionUpdate($id)
    {
        $photo = $this->getPhoto($id);

        $data = Yii::$app->request->post();
        $photo->title = $data["title"];
        $photo->description = $data["description"];
        $photo->save();

        return $photo;
        
    }

    public function actionDelete($id)
    {
        $photo = $this->getPhoto($id);
        $photo->delete();

        return "photo deleted";
    }
}
