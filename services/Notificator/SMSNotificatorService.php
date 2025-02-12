<?php

namespace app\services\Notificator;

use app\jobs\SendSMSJob;
use Yii;

class SMSNotificatorService implements NotificatorInterface
{
    public function send(int $phoneNumber, string $message): void
    {
        Yii::$app->queue->push(new SendSmsJob([
            'phoneNumber' => $phoneNumber,
            'message' => $message,
        ]));
    }
}