<?php

namespace common\models;

use Yii;
use common\models\Collection;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property int $collection_id
 * @property string|null $author
 * @property string|null $description
 * @property string $url
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['collection_id', 'url'], 'required'],
            [['collection_id', 'created_at', 'updated_at'], 'integer'],
            [['author', 'description', 'url'], 'string', 'max' => 255],
            [['author', 'description'], 'default', 'value' => null],
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
            'author' => 'Author',
            'description' => 'Description',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

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
        $path = Yii::$app->basePath . '/web/uploads/' . $this->collection->user_id . '/' . $this->collection->id . '/file_id_' . $this->id . '.' . $ext;

        if (file_exists($path)) {
            unlink($path);
        }

        return true;
    }
}
