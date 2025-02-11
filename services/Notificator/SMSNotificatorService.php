<?php

namespace app\services\Notificator;

use app\services\OTPCode\NotificatorInterface;

class SMSNotificatorService implements NotificatorInterface
{

    public function send(int $phone, string $message): void
    {
//        echo 'СМС НОТИФ!'; die();
    }
}