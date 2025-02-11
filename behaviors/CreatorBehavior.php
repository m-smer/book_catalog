<?php
namespace app\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class CreatorBehavior extends Behavior
{
    public string $attribute = 'creator_id';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'setCreatorId',
        ];
    }

    public function setCreatorId(): void
    {
        $user = \Yii::$app->user;
        $this->owner->{$this->attribute} = $user->getId();
    }
}