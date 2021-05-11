<?php

namespace common\tests;

use common\fixtures\CollectionFixture;
use common\fixtures\UserFixture;
use common\models\Collection;
use common\models\LoginForm;
use yii\helpers\VarDumper;

class CollectionTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

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


    public function testCreateCollection()
    {
        $user = $this->tester->grabFixture('user', 0);

        $this->tester->haveRecord(Collection::class, [
            "user_id" => $user->id,
            "title" => "The Hobbit"
        ]);
        $this->tester->seeRecord(Collection::class, [
            "user_id" => $user->id,
            "title" => "The Hobbit"
        ]);
        // $stub = $this->make(Collection::class, [
        //     "user_id" => 1,
        //     "title" => "The Hobbit"
        // ]);
        // $this->assertTrue($stub->validate());
        // $this->assertTrue($stub->save());
    }

    public function testCreateCollectionWrongUserId()
    {
        $userId = 200;
        $user = $this->tester->grabFixture('user', $userId);
        $this->assertEmpty($user);
        $this->tester->dontSeeRecord(Collection::class, [
            "user_id" => $userId,
        ]);
        // $stub = $this->make(Collection::class, [
        //     "user_id" => 2000,
        //     "title" => "The Hobbit"
        // ]);
        // $this->assertTrue($stub->validate(['title']));
        // $this->assertFalse($stub->validate(['user_id']));
        // $this->assertFalse($stub->save());
    }

    public function testCreateCollectionWrongTitle()
    {
        $stub = $this->make(Collection::class, [
            "user_id" => 1,
            "title" => 123
        ]);

        $this->assertTrue($stub->validate(['user_id']));
        $this->assertFalse($stub->validate());
        $this->assertFalse($stub->save());
    }

    public function testUpdateCollection()
    {
        $stub = $this->make(Collection::class, [
            "user_id" => 1,
            "title" => "The Hobbit"
        ]);

        $stub->title = "Lord of the ring";
        $stub->save();

        $this->assertTrue($stub->validate());
        $this->assertTrue($stub->save());
    }

    public function testFailUpdateCollection()
    {
        $stub = $this->make(Collection::class, [
            "user_id" => 1,
            "title" => "The Hobbit"
        ]);

        $stub->title = 123;
        $stub->save();

        $this->assertFalse($stub->validate());
        $this->assertFalse($stub->save());
    }

    public function testDeleteCollection()
    {
        $stub = $this->make(Collection::class, [
            "user_id" => 1,
            "title" => "The Hobbit"
        ]);

        $valueTrue = '1';
        $responseSave = $stub->save();
        $this->assertTrue($responseSave);
        $responseDelete =  $stub->delete();

        $this->assertEquals($valueTrue, $responseDelete);
    }
    public function testGetCollection()
    {
        $stub = $this->make(Collection::class, [
            "user_id" => 1,
            "title" => "The Hobbit"
        ]);

        $responseSave = $stub->save();
        $this->assertTrue($responseSave);

        $collection = Collection::findOne(1);
        $this->assertNotEmpty($collection);
        $collectionCreated = Collection::findOne(3);
        $this->assertNotEmpty($collectionCreated);
        $collectionNotExist = Collection::findOne(4);
        $this->assertEmpty($collectionNotExist);
    }
}
