<?php

namespace frontend\controllers;

use common\models\Collection;
use Yii;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\helpers\VarDumper;
use yii\web\View;

class UnsplashController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('search');
    }

    public function actionShow()
    {
        $term = Yii::$app->request->post('term');

        $key = 'HxQzenO99ZGmXEIQ0Tgk4JHV5P3bRhH84LMnbkglDPA';

        $client = new Client(['baseUrl' => 'https://api.unsplash.com/']);

        $response = $client->get('search/photos', ['client_id' => $key, 'query' => $term])->send();

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
            'unsplash' => $response->getData(),
            'collection' => new Collection(),
            'collections' => $collections
        ]);
    }
}
