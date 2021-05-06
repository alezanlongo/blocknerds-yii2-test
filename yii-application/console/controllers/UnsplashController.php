<?php

namespace console\controllers;

use common\models\Collection;
use common\models\Image;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\console\widgets\Table;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseConsole;
use yii\helpers\Console;

class UnsplashController extends Controller
{
    // public $query = null;

    // public function options($actionID)
    // {
    //     return ['query'];
    // }

    // public function optionAliases()
    // {
    //     return ['q' => 'query'];
    // }

    public function actionIndex()
    {
        $this->stdout("1. Get images from Unsplash \n", Console::BOLD);
        $this->stdout("2. Get images from user's collection \n", Console::BOLD);
        $this->stdout("3. Exit \n");

        $action = $this->prompt(
            'What to do: ',
            [
                'required' => true,
                'validator' => function ($input, &$error) {
                    if (!in_array($input, [1, 2, 3])) {
                        $error = 'Please choose a valid option';
                        return false;
                    }
                    return true;
                },
            ]
        );

        switch ($action) {
            case 1:
                $this->stdout("Getting images from Unsplash \n", Console::FG_BLUE);
                $this->getUnsplash();
                break;
            case 2:
                $this->stdout("Getting images from user's collection \n", Console::FG_BLUE);
                $this->getCollections();
                break;
            case 3:
                $this->stdout("Good bye! \n", Console::FG_YELLOW);
                return ExitCode::OK;
                break;
        }
    }

    protected function getCollections()
    {
        $user_id = $this->prompt(
            'Provide a user ID: ',
            [
                'required' => true,
                'validator' => function ($input, &$error) {
                    if (!is_numeric($input)) {
                        $error = 'Please provide a integer number';
                        return false;
                    }
                    return true;
                },
            ]
        );

        $collectionsIds = Collection::find()->where(['user_id' => $user_id])->select('id')->column();

        $images = Image::findAll(['collection_id' => $collectionsIds]);

        if (count($images) < 1) {
            $this->stdout("There isn't images for user ID $user_id", Console::FG_RED);
        } else {
            $this->displayCollectionTable($images);
        }

        return ExitCode::OK;
    }

    protected function displayCollectionTable($data)
    {
        $rows = [];

        foreach ($data as $item) {
            $rows[] = [
                $item['collection_id'],
                $item['id'],
                trim($item['url']) == "" ? "Unknown" : substr($item['url'], 0, 55),
                trim($item['author']) == "" ? "Unknown" : substr($item['author'], 0, 25),
                trim($item['description']) == "" ? "Unknown" : substr($item['description'], 0, 25)
            ];
        }

        echo Table::widget([
            'headers' => ['Collection ID', 'Image ID', 'URL', 'Author', 'Description'],
            'rows' => $rows,
        ]);
    }

    protected function getUnsplash()
    {
        $query = BaseConsole::input("Term to search: ");

        if ($data = Yii::$app->unsplash->get($query)) {
            if (ArrayHelper::keyExists('errors', $data, false)) {
                $this->stdout($data['errors'][0], Console::BG_RED);
            } else {
                $this->displayUnsplashTable($data);
            }
            return ExitCode::OK;
        }

        echo "Something went wrong try again later.\n";
        return ExitCode::UNSPECIFIED_ERROR;
    }

    protected function displayUnsplashTable($data)
    {
        $rows = [];

        foreach ($data['results'] as $item) {
            $rows[] = [
                $item['id'],
                trim($item['urls']['thumb']) == "" ? "Unknown" : substr($item['urls']['thumb'], 0, 55),
                trim($item['user']['name']) == "" ? "Unknown" : substr($item['user']['name'], 0, 25),
                trim($item['description']) == "" ? "Unknown" : substr($item['description'], 0, 25)
            ];
        }

        echo Table::widget([
            'headers' => ['ID', 'URL', 'Author', 'Description'],
            'rows' => $rows,
        ]);
    }
}
