<?php

namespace common\models;

use common\models\User;
use common\models\Image;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "collection".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getImages()
    {
        return $this->hasMany(Image::class, ['collection_id' => 'id']);
    }

    public function afterSave($insert = true, $changedAttributes = null)
    {

        $path = Yii::getAlias('@frontend') . '/web/uploads/' . $this->user_id . '/' . $this->id;
        BaseFileHelper::createDirectory($path, 0775, true);
    }

    public function afterDelete()
    {
        Image::deleteAll(['collection_id' => $this->id]);
        $path = Yii::getAlias('@frontend') . '/web/uploads/' . $this->user_id . '/' . $this->id;
        BaseFileHelper::removeDirectory($path);
    }
}
