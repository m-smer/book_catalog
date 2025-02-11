<?php

namespace app\services\OTPCode;

interface NotificatorInterface
{
    public function send(int $phone, string $message): void;
}