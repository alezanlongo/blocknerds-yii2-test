<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\console\widgets\Table;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\helpers\VarDumper;

class FavoriteController extends Controller
{
    public $email;
    public $username;

    public function options($actionID)
    {
        return ['email', 'username'];
    }

    public function optionAliases()
    {
        return [
            'e' => 'email',
            'u' => 'username',
        ];
    }

    public function actionIndex()
    {

        if (!$this->email && !$this->username) {
            echo "Email is missing \n";
            echo "Execute tag --email / -m or --username / -u \n";

            return ExitCode::NOUSER;
        }

        $user = null;

        if ($this->email) {
            $user = User::find()->where(['email' => $this->email])->one();
        }

        if ($this->username && !$user) {
            $user = User::find()->where(['username' => $this->username])->one();
        }

        if (!$user) {
            echo "User not found. \n";

            return ExitCode::NOUSER;
        }

        $headers = ["Collection Name", "Photos"];
        $rows = [];
        $collections = $user->getCollections()->with("photos")->asArray()->all();
    //   $rowPhotos=  ArrayHelper::map($collections, 'title', function ($collection) {
    //       return  $rowPhotos[] = ArrayHelper::getColumn($collection['photos'], function ($photo) {
    //             return $photo['photo_id'] . " - " . $photo['url'];
    //         });
    //     });
        
        foreach ($collections as $collection) {
            $rowPhotos = [];
            $photos = ArrayHelper::getColumn($collection['photos'], function ($photo) {
                return $photo['photo_id'] . " - " . $photo['url'];
            });
           
            $rowPhotos[] = $collection['title'];
            $rowPhotos[] = $photos;
            $rows[] = $rowPhotos;
        }

        echo Table::widget([
            'headers' => $headers,
            'rows' => $rows,
        ]);

        return ExitCode::OK;
    }
}
