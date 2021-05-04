<?php

namespace frontend\controllers\api;

use common\models\User;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

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
        $model = User::findOne(['username' => $post['username']]);

        if (empty($model)) {
            throw new NotFoundHttpException('User not found');
        }

        if (!$model->validatePassword($post['password'])) {
            throw new ForbiddenHttpException('Please check your username and password and try again');
        }

        return $model; //return whole user model including auth_key or you can just return $model['auth_key'];
    }
}
