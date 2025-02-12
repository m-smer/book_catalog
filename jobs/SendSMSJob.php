<?php
namespace app\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;

class SendSMSJob extends BaseObject implements JobInterface
{
    public int $phoneNumber;
    public string $message;

    public function execute($queue)
    {
        $apiKey = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';
        // Выполнение GET-запроса
        $url = 'https://smspilot.ru/api.php?send=' . urlencode($this->message) . '&to=' . $this->phoneNumber . '&apikey=' . $apiKey . '&format=v';
        $result = file_get_contents($url);

        echo var_export($result ,1) . PHP_EOL;
    }
}