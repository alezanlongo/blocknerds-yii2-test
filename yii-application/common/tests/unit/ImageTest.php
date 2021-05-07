<?php

namespace common\tests;

use common\fixtures\CollectionFixture;
use common\fixtures\UserFixture;
use common\fixtures\ImageFixture;
use common\models\LoginForm;
use common\models\Image;

class ImageTest extends \Codeception\Test\Unit
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
                ],
                'image' => [
                    'class' => ImageFixture::class,
                    'dataFile' => codecept_data_dir() . 'image.php'
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
        $image = $this->getMockBuilder(Image::class)
            ->getMock();

        $image->method('save')
            ->willReturn(true);

        $this->assertNotFalse($image->save());
    }

    // tests
    public function testCreateImage()
    {
        (new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]))->login();

        $image = $this->make(Image::class, [
            "collection_id" => 1,
            "author" => 'someone',
            "description" => 'some description',
            'url' => 'https://images.unsplash.com/photo-1618757850520-6e3e48d07746?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfHNlYXJjaHw0fHxhc2R8ZW58MHx8fHwxNjIwMTUwNTU5&ixlib=rb-1.2.1&q=80&w=400',
        ]);

        $this->assertTrue($image->save());
    }

    // tests
    public function testUpdateImage()
    {
        (new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]))->login();

        $image = Image::findOne(1);
        $image->description = 'new description';

        $this->assertTrue($image->save());
    }

    // tests
    public function testDeleteImage()
    {
        (new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]))->login();

        $image = Image::findOne(1);

        $this->assertEquals(1, $image->delete());
    }

    // test
    public function testImageWrongCollectionId()
    {
        (new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]))->login();

        $image = $this->make(Image::class, [
            "collection_id" => 2,
            "author" => 'someone',
            "description" => 'some description',
            'url' => 'https://images.unsplash.com/photo-1618757850520-6e3e48d07746?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMjQ2NTl8MHwxfHNlYXJjaHw0fHxhc2R8ZW58MHx8fHwxNjIwMTUwNTU5&ixlib=rb-1.2.1&q=80&w=400',
        ]);

        $this->assertFalse($image->save());
    }
}
