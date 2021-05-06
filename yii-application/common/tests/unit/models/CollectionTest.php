<?php

namespace common\tests;

use common\fixtures\UserFixture;
use common\models\Collection;
use common\models\LoginForm;

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
            ]
        ]);
    }

    protected function _after()
    {
    }


    public function testCreateCollection()
    {
        $stub = $this->make(Collection::class, [
            "user_id" => 1,
            "title" => "The Hobbit"
        ]);

        $this->assertTrue($stub->validate());
        $this->assertTrue($stub->save());
    }

    public function testCreateCollectionWrongUserId()
    {
        $stub = $this->make(Collection::class, [
            "user_id" => null,
            "title" => "The Hobbit"
        ]);

        $this->assertTrue($stub->validate(['title']));
        $this->assertNotTrue($stub->validate());
        $this->assertFalse($stub->save());
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
}
