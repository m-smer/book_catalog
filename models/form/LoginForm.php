<?php

namespace app\models\form;

use app\models\OTPCode;
use app\models\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public ?int $phone_number = null;
    public ?string $otp_code = null;
    public bool $rememberMe = true;

    private ?User $_user = null;


    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['phone_number', 'otp_code'], 'required'],
            [['phone_number'], 'integer'],
            [['otp_code'], 'validateOTPCode'],
            ['rememberMe', 'boolean'],
        ];
    }


    public function validateOTPCode($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validateOTPCode($this->otp_code)) {
                $this->addError($attribute, 'Incorrect code or phone number.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[phone_number]]
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findIdentityPhoneNumber($this->phone_number);
        }
        return $this->_user;
    }
}
