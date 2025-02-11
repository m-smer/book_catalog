<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $image_id
 * @property string $filename
 * @property string $extension
 * @property string $owner_type
 * @property int $owner_id
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filename', 'extension', 'owner_type', 'owner_id'], 'required'],
            [['owner_id'], 'integer'],
            [['filename', 'extension', 'owner_type'], 'string', 'max' => 255],
            [['filename'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'Image ID',
            'filename' => 'Filename',
            'extension' => 'Extension',
            'owner_type' => 'Owner Type',
            'owner_id' => 'Owner ID',
        ];
    }

    public function getImages()
    {
        return $this->hasMany(Image::class, ['owner_id' => 'book_id'])
            ->andWhere(['owner_type' => 'book']);
    }
}
