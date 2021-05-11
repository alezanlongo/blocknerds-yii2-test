<?php
namespace common\fixtures;

use common\fixtures\UserFixture;
use common\models\Collection;
use yii\test\ActiveFixture;

class CollectionFixture extends ActiveFixture
{
    public $modelClass = Collection::class;
    public $depends = [UserFixture::class];
}