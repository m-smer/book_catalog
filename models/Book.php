<?php

namespace app\models;

use app\services\OTPCode\OTPCodeService;
use Yii;
use yii\caching\TagDependency;

/**
 * This is the model class for table "book".
 *
 * @property int $book_id
 * @property string $title
 * @property int $year
 * @property string $isbn
 *
 * @property Author[] $authors
 * @property Image[] $images
 * @property BookAuthor[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'year', 'isbn'], 'required'],
            [['year'], 'integer', 'max' => date('Y')],
            [['title', 'isbn'], 'string', 'max' => 255],
            [['isbn'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'book_id' => 'Book ID',
            'title' => 'Title',
            'year' => 'Year',
            'isbn' => 'Isbn',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['author_id' => 'author_id'])->via('bookAuthors');
    }

    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'book_id']);
    }

    public function getImages()
    {
        return $this->hasMany(Image::class, ['owner_id' => 'book_id'])
            ->andWhere(['owner_type' => 'book']);
    }

    public function beforeSave($insert): bool
    {
        // сносим кэш рейтинга авторов
        TagDependency::invalidate(Yii::$app->cache, [Author::TOP_CACHE_KEY_PREFIX]);
        return parent::beforeSave($insert);
    }

    public function afterDelete(): void
    {
        //можно перенести в behavior
        TagDependency::invalidate(Yii::$app->cache, [Author::TOP_CACHE_KEY_PREFIX]);
        parent::afterDelete();
    }

}
