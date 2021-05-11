<?php

namespace frontend\tests\functional;

use Codeception\Util\ActionSequence;
use common\fixtures\CollectionFixture;
use common\fixtures\PhotoFixture;
use common\fixtures\UserFixture;
use common\models\Collection;
use common\models\LoginForm;
use common\models\User;
use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use frontend\tests\FunctionalTester;
use Yii;
use yii\helpers\VarDumper;

class CollectionCest
{
    protected $model;
    protected $formId = '#collection-form';


    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
            'collection' => [
                'class' => CollectionFixture::class,
                'dataFile' => codecept_data_dir() . 'collection.php',
            ],
            'photo' => [
                'class' => PhotoFixture::class,
                'dataFile' => codecept_data_dir() . 'photo.php',
            ],
        ];
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['site/login']);
        $I->submitForm('#login-form', $this->formParams('erau', 'password_0'));
    }

    // private function getFirstCollecion()
    // {
    //     return Collection::find()->where([
    //         "user_id" => Yii::$app->user->id
    //     ])->limit(1)->one();
    // }

    public function tryToIndexCollection(FunctionalTester $I)
    {
        $I->amOnPage(['collection/index']);
        $I->seeLink('Create Collection');
        $I->see('Collections', 'h1');
    }

    public function tryToCreateCollection(FunctionalTester $I)
    {
        $title = "Dogs";

        $I->amOnPage(['collection/create']);
        $I->submitForm($this->formId, [
            'Collection[title]' => $title,
        ]);
        $I->seeRecord(Collection::class, [
            'user_id' => Yii::$app->user->id,
            'title' => $title,
        ]);
    }

    public function tryToCreateEmptyCollection(FunctionalTester $I)
    {
        $title = "";
        $I->amOnPage(['collection/create']);
        $I->submitForm($this->formId, [
            'Collection[title]' => $title,
        ]);
        $I->see("Title cannot be blank.", ".help-block");
    }

    public function TryToViewACollection(FunctionalTester $I)
    {
        $collectionId = 1;
        $collection = Collection::findOne([
            "user_id" => Yii::$app->user->id,
            "id" => $collectionId,
        ]);
        $I->amOnPage(['collection/index']);
        $viewUrl = "collection/view?id=$collection->id";
        $I->amOnPage([$viewUrl]);
        $I->see($collection->title, 'h1');
        $I->seeElement('.card-columns');
    }

    public function TryToUpdateCollection(FunctionalTester $I)
    {
        $collectionId = 1;
        $I->amOnPage(['collection/index']);
        $collection = Collection::findOne([
            "user_id" => Yii::$app->user->id,
            "id" => $collectionId,
        ]);

        $updatedTitle = "changed $collection->title";
        $userId = Yii::$app->user->id;
        $viewUrl = "collection/update?id=$collection->id";
        $I->amOnPage([$viewUrl]);
        $I->see("Update Collection: $collection->title", 'h1');
        $I->submitForm($this->formId, [
            'Collection[title]' => $updatedTitle,
        ]);

        $I->seeRecord(Collection::class, [
            'id' => $collection->id,
            'user_id' => $userId,
            'title' => $updatedTitle,
        ]);
        $I->see($updatedTitle, 'h1');
    }

    public function TryToRemoveCollection(FunctionalTester $I)
    {
        // $url = 'http://selenium-hub:4444/wd/hub';
        // $capabilities = array(WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        // $webDriver = RemoteWebDriver::create($url, $capabilities);
        // $webDriver->get('http://172.25.0.2:4444/wd/hub');
        // $options = (new FirefoxOptions)->addArguments([
        //     '--disable-gpu',
        //     '--headless',
        //     '--no-sandbox',
        //     '--window-size=1920,1080',
        // ]);
        // RemoteWebDriver::create(
        //     'http://selenium:4444/wd/hub',
        //     FirefoxOptions::CAPABILITY,
        //     $options
        // )->setCapability('acceptInsecureCerts', TRUE);
        $collectionId = 1;
        $collectionTitle = "Hobbit";
        $userId = Yii::$app->user->id;
        $viewUrl = "collection/view?id=$collectionId";

        $I->amOnPage([$viewUrl]);
        $I->see($collectionTitle, 'h1');
        $I->click("Delete");
        // $I->switchToWindow();

        // $I->performOn(
        //     '.confirm',
        //     ActionSequence::build()
        //         // ->see('Warning')
        //         ->see('Are you sure you want to delete this item?')
        //         ->click('Aceptar')
        // );

        // $I->see("Collection deleted.");

        // $I->submitForm($this->formId, [
        //     'Collection[title]' => $updatedTitle,
        // ]);

        // $I->seeRecord(Collection::class, [
        //     'id' => $collection->id,
        //     'user_id' => $userId,
        //     'title' => $updatedTitle,
        // ]);
        // $I->see($updatedTitle, 'h1');

    }
}
