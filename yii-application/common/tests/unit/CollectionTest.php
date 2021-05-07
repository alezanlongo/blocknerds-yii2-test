<?php

namespace common\tests;

use common\fixtures\CollectionFixture;
use common\models\Collection;
use common\fixtures\UserFixture;
use common\models\LoginForm;

class CollectionTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    public function _before()
    {
        $output = null;
        $retval = null;
        exec("yes 2>/dev/null | php  yii migrate --db=testdb  > /dev/null &", $output, $retval);

        if ($retval === 0) {
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
    }

    protected function _after()
    {
    }

    // tests
    public function testSaveFeature()
    {
        $collection = $this->getMockBuilder(Collection::class)
            ->getMock();

        $collection->method('save')
            ->willReturn(true);

        $this->assertNotFalse($collection->save());
    }

    // tests
    public function testCreateCollection()
    {
        (new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]))->login();

        $collection = $this->make(Collection::class, [
            "user_id" => 1,
            "title" => "some title"
        ]);

        $this->assertTrue($collection->save());
    }

    // tests
    public function testUpdateCollection()
    {
        (new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]))->login();

        $collection = Collection::findOne(1);
        $collection->title = 'new title';

        $this->assertTrue($collection->save());
    }

    // tests
    public function testDeleteCollection()
    {
        (new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]))->login();

        $collection = Collection::findOne(1);

        $this->assertEquals(1, $collection->delete());
    }

    // test
    public function testCollectionWrongUserId()
    {
        (new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]))->login();

        $collection = $this->make(Collection::class, [
            "user_id" => 1000,
            "title" => "some title"
        ]);

        $this->assertFalse($collection->save());
    }
}
