<?php

namespace frontend\controllers;

use common\models\Collection;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\View;

class UnsplashController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('search');
    }

    public function beforeAction($action)
    {
        if ($action->actionMethod === 'actionShow') {
            $dt = new \DateTime();
            Yii::info("action method '{$action->actionMethod}' start: {$dt->format('Y-m-d H:i:s')}");
        }
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        if ($action->actionMethod === 'actionShow') {
            $dt = new \DateTime();
            Yii::info("action method '{$action->actionMethod}' finish: {$dt->format('Y-m-d H:i:s')}");
        }
        return parent::afterAction($action, $result);
    }

    public function actionShow()
    {
        $term = Yii::$app->request->post('term');

        $unsplash = Yii::$app->unsplash->get($term);

        $collections = Yii::$app->user->identity->getCollections()->asArray()->all();

        $collections = ArrayHelper::map($collections, 'id', 'title');

        Yii::$app->view->registerJsVar('csrf', Yii::$app->request->getCsrfToken(), view::POS_END);
        Yii::$app->view->registerJsFile(
            '/js/unsplash.js',
            [
                'depends' => "yii\web\JqueryAsset",
                'position' => View::POS_END
            ]
        );

        return $this->render('index', [
            'term' => $term,
            'unsplash' => $unsplash,
            'collection' => new Collection(),
            'collections' => $collections
        ]);
    }
}
