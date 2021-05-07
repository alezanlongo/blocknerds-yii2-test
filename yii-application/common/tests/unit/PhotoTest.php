<?php

namespace common\tests;

use Codeception\Lib\Connector\Yii2\FixturesStore;
use Codeception\Util\Fixtures;
use common\fixtures\CollectionFixture;
use common\fixtures\UserFixture;
use common\models\Collection;
use common\models\Photo;
use yii\helpers\VarDumper;

class PhotoTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;
    protected $collection;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'collection' => [
                'class' => CollectionFixture::class,
                'dataFile' => codecept_data_dir() . 'collection.php'
            ]
        ]);
    }

    protected function _after()
    {
    }

    public function testCreatePhoto()
    {
        $stub = $this->make(Photo::class, [
            "collection_id" => 1,
            'photo_id' => "5as1d5",
            'url' => "https://images.unsplash.com/photo-1618757850520-6e3e48d07746?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfHNlYXJjaHw0fHxhc2R8ZW58MHx8fHwxNjIwMTUwNTU5&ixlib=rb-1.2.1&q=80&w=400",
            "title" => "img title",
            "description" => "some description"
        ]);

        $this->assertTrue($stub->validate());
        $this->assertTrue($stub->save());
    }

    public function testCreatePhotoWrongCollection()
    {
        $stub = $this->make(Photo::class, [
            "collection_id" => 20,
            'photo_id' => "5as1d5",
            'url' => "https://images.unsplash.com/photo-1618757850520-6e3e48d07746?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfHNlYXJjaHw0fHxhc2R8ZW58MHx8fHwxNjIwMTUwNTU5&ixlib=rb-1.2.1&q=80&w=400",
            "title" => "img title",
            "description" => "some description"
        ]);

        $this->assertFalse($stub->validate(['collection_id']));
        $this->assertFalse($stub->save());
    }

    public function testUpdatePhoto()
    {
        $stub = $this->make(Photo::class, [
            "collection_id" => 2,
            'photo_id' => "5as1d5",
            'url' => "https://images.unsplash.com/photo-1618757850520-6e3e48d07746?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfHNlYXJjaHw0fHxhc2R8ZW58MHx8fHwxNjIwMTUwNTU5&ixlib=rb-1.2.1&q=80&w=400",
            "title" => "img title",
            "description" => "some description"
        ]);

        $this->assertTrue($stub->save());

        $newTitle = "Something else";
        $stub->title = $newTitle;
        $stub->save();

        $this->assertTrue($stub->save());
        $this->assertEquals($stub->title, $newTitle);
    }

    public function testUpdatePhotoWrong()
    {
        $stub = $this->make(Photo::class, [
            "collection_id" => 1,
            'photo_id' => "5as1d5",
            'url' => "https://images.unsplash.com/photo-1618757850520-6e3e48d07746?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfHNlYXJjaHw0fHxhc2R8ZW58MHx8fHwxNjIwMTUwNTU5&ixlib=rb-1.2.1&q=80&w=400",
            "title" => "img title",
            "description" => "some description"
        ]);

        $newTitle = 2;
        $stub->title = $newTitle;
        $stub->save();

        $this->assertFalse($stub->save());
    }

    public function testDeletePhoto()
    {
        $stub = $this->make(Photo::class, [
            "collection_id" => 1,
            'photo_id' => "5as1d5",
            'url' => "https://images.unsplash.com/photo-1618757850520-6e3e48d07746?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfHNlYXJjaHw0fHxhc2R8ZW58MHx8fHwxNjIwMTUwNTU5&ixlib=rb-1.2.1&q=80&w=400",
            "title" => "img title",
            "description" => "some description"
        ]);
        $valueTrue = '1';
        $responseSave = $stub->save();
        $this->assertTrue($responseSave);
        $responseDelete =  $stub->delete();

        $this->assertEquals($valueTrue, $responseDelete);
    }
}
