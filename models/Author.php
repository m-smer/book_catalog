<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $author_id
 * @property string $full_name
 *
 * @property Book[] $books
 * @property Subscription[] $subscriptions
 * @property User[] $users
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['full_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'author_id' => 'Author ID',
            'full_name' => 'Full Name',
        ];
    }


    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['book_id' => 'book_id'])->viaTable('book_author', ['author_id' => 'author_id']);
    }

    /**
     * Gets query for [[Subscriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::class, ['author_id' => 'author_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['user_id' => 'user_id'])->viaTable('subscription', ['author_id' => 'author_id']);
    }
}
