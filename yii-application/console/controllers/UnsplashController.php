<?php

namespace console\controllers;

use frontend\controllers\UnsplashController as ControllersUnsplashController;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\console\widgets\Table;

class UnsplashController extends Controller
{
    public $word;

    public function options($actionID)
    {
        return ['word'];
    }

    public function optionAliases()
    {
        return ['w' => 'word'];
    }

    public function actionSearch()
    {
        $response = ControllersUnsplashController::search($this->word);
        $headers = ["id","description","url"]; 
        $rows =[];
        $photos = $response->getData()["results"];

        foreach ($photos as $photo ) {
            $rows[]=[
                $photo["id"],
                $photo["description"],
                $photo["urls"]["small"],
            ];
        }
        
        echo Table::widget([
            'headers' => $headers,
            'rows' => $rows,
        ]);
        
        return ExitCode::OK;
    }
}
