<?php

namespace frontend\tests\functional;

use common\fixtures\CollectionFixture;
use common\fixtures\PhotoFixture;
use common\fixtures\UserFixture;
use common\models\LoginForm;
use common\models\Photo;
use frontend\tests\FunctionalTester;
use Yii;
use yii\helpers\VarDumper;

class PhotoCest
{
    protected $model;
    protected $formId = "#photo-form";

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

    public function _before(FunctionalTester $I)
    {
        $this->model = new LoginForm([
            'username' => 'erau',
            'password' => 'password_0',
        ]);
        $this->model->login();
    }

    public function tryToGetPhoto(FunctionalTester $I)
    {
        $photoId = 1;
        $photo = Photo::findOne($photoId);
        $I->amOnPage(["photo/view?id=$photoId"]);
        $I->see($photo->title, "h1");
        $I->see($photo->title, "h5.card-title");
        $I->seeElement('//img[@src="' . $photo->url . '"]');
        $I->see($photo->description, "p.card-text");
    }

    public function tryToUpdatePhotoFieldEmpty(FunctionalTester $I)
    {
        $photoId = 1;
        $photo = Photo::findOne($photoId);
        $I->amOnPage(["photo/update?id=$photoId"]);
        $I->see("Update Photo: $photo->title", "h1");

        $I->submitForm($this->formId, [
            'Photo[url]' => '',
            'Photo[title]' => '',
        ]);
        $I->see('Url cannot be blank.', '.help-block');
        $I->see('Title cannot be blank.', '.help-block');
    }

    public function tryToUpdatePhoto(FunctionalTester $I)
    {
        $photoId = 1;
        $newPhotoTitle = "The Hobbit";
        $newPhotoDescription = "Something description";
        $newPhotoUrl = 'https://images.unsplash.com/photo-1620136619922-f592abb9df44?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfGFsbHx8fHx8fHx8fDE2MjAyNDI2OTU&ixlib=rb-1.2.1&q=80&w=400';

        $I->amOnPage(["photo/update?id=$photoId"]);

        $I->submitForm($this->formId, [
            'Photo[url]' => $newPhotoUrl,
            'Photo[title]' => $newPhotoTitle,
            'Photo[description]' => $newPhotoDescription,
        ]);

        $I->seeRecord(Photo::class, [
            'url' => $newPhotoUrl,
            'title' => $newPhotoTitle,
            'description' => $newPhotoDescription,
        ]);

        $I->amOnPage(["photo/view?id=$photoId"]);
        $I->see($newPhotoTitle, "h1");
        $I->see($newPhotoTitle, "h5.card-title");
        $I->seeElement('//img[@src="' . $newPhotoUrl . '"]');
        $I->see($newPhotoDescription, "p.card-text");
    }
}
