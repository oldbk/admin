<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\validatorItem;


use common\models\questTask\EventTask;
use yii\base\Model;

abstract class BaseValidator extends Model implements iValidator
{
    const ITEM_TYPE_FIGHT           = 'fight';
    const ITEM_TYPE_LOCATION        = 'location';
    const ITEM_TYPE_USER            = 'user';
    const ITEM_TYPE_GAME_ENTER      = 'gameEnter';

    public static function getValidator($type)
    {
        $type = str_replace(' ', '', ucwords(str_replace('_', ' ', $type)));
        $className = sprintf('common\models\validatorItem\\%sValidator', ucfirst($type));
        try {
            return new $className();
        } catch (\Exception $ex) {
            return null;
        }
    }

    public function getTitle()
    {
        return static::getTypeTitles()[$this->getItemType()];
    }

    public static function getTypeTitles()
    {
        return [
            self::ITEM_TYPE_FIGHT       => 'Бой',
            self::ITEM_TYPE_LOCATION    => 'Локация',
            self::ITEM_TYPE_USER        => 'Персонаж',
            self::ITEM_TYPE_GAME_ENTER  => 'Вход в игру',
        ];
    }

    public static function getTypeWithCondition($task)
    {
        $items = self::getTypeTitles();
        if($task != EventTask::EVENT_GAME_ENTER) {
            unset($items[self::ITEM_TYPE_GAME_ENTER]);
        }

        return $items;
    }
}