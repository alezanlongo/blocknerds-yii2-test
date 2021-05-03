<?php

namespace frontend\controllers\api;

use common\models\User;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

class AuthController extends ActiveController
{
    public $modelClass = User::class;

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

    public function actionLogin()
    {
        $post = Yii::$app->request->post();
        $model = User::findOne(['email' => $post['email']]);
        if (empty($model)) {
            throw new \yii\web\NotFoundHttpException('User not found');
        }
        if ($model->validatePassword($post['password'])) {
            return $model; //return whole user model including auth_key or you can just return $model['auth_key'];
        } else {
            throw new \yii\web\ForbiddenHttpException('Please check your username and password and try again');
        }
    }
}
