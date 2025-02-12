<?php

namespace app\services\OTPCode;

use app\models\User;
use app\services\Notificator\NotificatorInterface;

class OTPCodeService
{
    private const string CACHE_PREFIX = 'OTPCode_';

    // время жизни одноразового кода
    private const int TTL = 300;

    public function __construct(
        private readonly NotificatorInterface $notificator
    )  {}

    private function generate($length = 6): string
    {
        //todo генерить нормальный код.
        return 'q';
    }

    public function setNewCode(int $phoneNumber, ?string $code = null): void
    {
        $code ??= $this->generate();
        $cacheKey = $this->getCacheKey($phoneNumber);
        \Yii::$app->cache->set($cacheKey, $code, static::TTL);
        $this->notificator->send($phoneNumber, $code);
    }

    public function isValid(User $user, string $code): bool
    {
        $cacheKey = $this->getCacheKey($user->phone_number);
        $rightCode = \Yii::$app->cache->get($cacheKey);
        return $rightCode && $rightCode === $code;
    }

    private function getCacheKey($phoneNumber): string
    {
        return self::CACHE_PREFIX . $phoneNumber;
    }

}