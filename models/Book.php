<?php

namespace app\models;

use Yii;

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
        return $this->hasMany(Author::class, ['author_id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'book_id']);
    }

    public function getImages()
    {
        return $this->hasMany(Image::class, ['owner_id' => 'book_id'])
            ->andWhere(['owner_type' => 'book']);
    }

//    public function getFirstImage()
//    {
//        return $this->hasOne(Image::class, ['owner_id' => 'book_id'])
//            ->andWhere(['owner_type' => 'book'])
//            ->one();
//    }

}
