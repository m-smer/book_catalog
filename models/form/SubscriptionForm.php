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
class SubscriptionForm extends Model
{
    public $phone_number;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['phone_number'], 'required'],
            [['phone_number'], 'integer'],
        ];
    }


}
