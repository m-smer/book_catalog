<?php

namespace app\models;

use app\services\OTPCode\OTPCodeService;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $user_id
 * @property string|null $full_name
 * @property int $phone_number
 * @property string $auth_key
 *
 * @property Subscription[] $subscriptions
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //todo правила на номер телефона
            [['phone_number', 'auth_key'], 'required'],
            [['phone_number'], 'integer'],
            [['full_name'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'full_name' => 'Full Name',
            'phone_number' => 'Phone Number',
            'auth_key' => 'Auth Key',
        ];
    }

    public function setOTPCodeService(OTPCodeService $OTPCodeService): void
    {
        $this->OTPCodeService = $OTPCodeService;
    }

    /**
     * Gets query for [[Subscriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions()
    {
        return $this->hasMany(Subscription::class, ['user_id' => 'user_id']);
    }

    public static function findIdentity($id): ?User
    {
        return static::findOne($id);
    }
    public static function findIdentityPhoneNumber(int $phoneNumber): ?User
    {
        return static::findOne(['phone_number' => $phoneNumber]);
    }

    public static function findIdentityByAccessToken($token, $type = null): null
    {
        return null;
    }

    public function getId(): int
    {
        return $this->user_id;
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    public function validateOTPCode(string $OTPCode): bool
    {
        $OTPCodeService = Yii::$container->get(OTPCodeService::class);

        return $OTPCodeService->isValid($this, $OTPCode);
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}
