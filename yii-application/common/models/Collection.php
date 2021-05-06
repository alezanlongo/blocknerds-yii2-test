<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "collection".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Photo[] $photos
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Photos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(Photo::class, ['collection_id' => 'id']);
    }

    public function afterSave($insert = true, $changedAttributes = null)
    {
        $path = Yii::getAlias('@frontend') . '/web/uploads/' . $this->user_id . '/' . $this->id;
        BaseFileHelper::createDirectory($path, 0775, true);
    }
    public function afterDelete()
    {
        Photo::deleteAll(['collection_id' => $this->id]);
        $path = Yii::getAlias('@frontend') . '/web/uploads/' . $this->user_id . '/' . $this->id;
        BaseFileHelper::removeDirectory($path);
    }
}
