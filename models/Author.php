<?php

namespace app\models;

use Yii;
use yii\caching\TagDependency;
use yii\db\Exception;
use yii\web\ForbiddenHttpException;

/**
 * This is the model class for table "author".
 *
 * @property int $author_id
 * @property string $full_name
 *
 * @property BookAuthor[] $bookAuthors
 * @property Book[] $books
 * @property Subscription[] $subscriptions
 * @property User[] $users
 */
class Author extends \yii\db\ActiveRecord
{
    public const TOP_CACHE_KEY_PREFIX = 'AUTHORS_TOP_';

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
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'author_id']);
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

    public function beforeDelete(): bool
    {
        $bookCount = $this->getBooks()->count();
        if ($bookCount > 0) {
            throw new ForbiddenHttpException('Нельзя удалить автора, пока существуют книги, им написанные.');
        }
        return parent::beforeDelete();
    }

    public static function getTop(int $limit = 10): array
    {
        $cacheKey = self::TOP_CACHE_KEY_PREFIX . $limit;
        if (!$array = Yii::$app->cache->get($cacheKey)) {
            $array =  Yii::$app->db->createCommand('
                SELECT full_name, count(book_id) as books_count
                FROM author
                LEFT JOIN book_author ON author.author_id = book_author.author_id
                group by author.author_id
                ORDER BY books_count DESC 
                limit :limit
            ')
                ->bindValue(':limit', $limit)
                ->queryAll();

            Yii::$app->cache->set(
                $cacheKey,
                $array,
                0,
                new TagDependency(['tags' => [self::TOP_CACHE_KEY_PREFIX]])
            );
        }

        return $array;
    }

}
