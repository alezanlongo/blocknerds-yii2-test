<?php

namespace app\models;

use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "collection".
 *
 * @property int $id
 * @property int $user_id
 * @property string $image
 * @property string|null $title
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
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['user_id', 'user_id', 'image', 'created_at', 'updated_at'], 'required'],
            [['title', 'image'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['image', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Image ID',
            // 'user_id' => 'User ID',
            'image' => 'Image URL',
            'title' => 'Title',
            // 'created_at' => 'Created At',
            // 'updated_at' => 'Updated At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
