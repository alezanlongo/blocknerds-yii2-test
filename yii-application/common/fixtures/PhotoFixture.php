<?php

namespace common\fixtures;

use common\fixtures\CollectionFixture;
use common\models\Photo;
use yii\test\ActiveFixture;

class PhotoFixture extends ActiveFixture
{
    public $modelClass = Photo::class;
    public $depends = [CollectionFixture::class];
}
