<?php

namespace frontend\controllers;

use Yii;
use yii\httpclient\Client;

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

        return $this->render('index', ['term' => $term, 'unsplash' => $response->getData()]);
    }
}
