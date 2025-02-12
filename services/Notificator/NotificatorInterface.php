<?php

namespace app\services\Notificator;

interface NotificatorInterface
{
    public function send(int $phoneNumber, string $message): void;
}