<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "photo".
 *
 * @property int $id
 * @property int $collection_id
 * @property string $photo_id
 * @property string $url
 * @property string $title
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Collection $collection
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo';
    }

     /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['collection_id', 'photo_id', 'url', 'title', 'created_at', 'updated_at'], 'required'],
            [['collection_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['collection_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['photo_id'], 'string', 'max' => 20],
            [['url', 'title'], 'string', 'max' => 255],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::class, 'targetAttribute' => ['collection_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'collection_id' => 'Collection ID',
            'photo_id' => 'Photo ID',
            'url' => 'Url',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Collection]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::class, ['id' => 'collection_id']);
    }

    public function afterDelete()
    {
        $this->deleteFileImage();
    }
    protected function deleteFileImage()
    {
        $ext = explode("&", explode("&fm=", $this->url)[1], 2)[0];
        $path = Yii::getAlias('@frontend') . '/web/uploads/' . $this->collection->user_id . '/' . $this->collection->id . '/' . $this->photo_id . '.' . $ext;
        if (file_exists($path)) {
            unlink($path);
        }
        return true;
    }
}
