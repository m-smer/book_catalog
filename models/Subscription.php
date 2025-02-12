<?php

namespace app\models;

use app\services\Notificator\NotificatorInterface;
use app\services\OTPCode\OTPCodeService;
use Yii;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "subscription".
 *
 * @property int $subscription_id
 * @property int $user_id
 * @property int $author_id
 *
 * @property Author $author
 * @property User $user
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'author_id'], 'required'],
            [['user_id', 'author_id'], 'integer'],
            [['user_id', 'author_id'], 'unique', 'targetAttribute' => ['user_id', 'author_id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'author_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'subscription_id' => 'Subscription ID',
            'user_id' => 'User ID',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['author_id' => 'author_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

    public static function subscribe(int $phone_number, int $authorId): bool
    {
        $userAttributes = ['phone_number' => $phone_number];
        $user = User::findOne($userAttributes);

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if (!$user) {
                $user = new User($userAttributes);
                if (!$user->save()) {
                    throw new \Exception('Не удалось сохранить пользователя.');
                }
            }

            $subscriptionAttributes = [
                'author_id' => $authorId,
                'user_id' => $user->user_id,
            ];


            if (!Subscription::findOne($subscriptionAttributes)) {
                $subscription = new self($subscriptionAttributes);
                if (!$subscription->save()) {
                    throw new \Exception('Не удалось сохранить подписку.');
                }
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public static function newBookNotify(Book $book): void
    {
        $notificator = Yii::$container->get(NotificatorInterface::class);

        foreach ($book->authors as $author) {
            foreach ($author->subscriptions as $subscription) {
                $message = 'У автора ' . $author->full_name . ' вышла новая книга ' . $book->title. '!';
                $notificator->send($subscription->user->phone_number, $message);
            }
        }
    }
}
