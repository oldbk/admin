<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 12.03.2016
 */

namespace frontend\models\questValidatorItemInfo;


use yii\base\Model;

abstract class BaseInfo extends Model
{
    const CONDITION_1 = '=';
    const CONDITION_2 = '>';
    const CONDITION_3 = '>=';
    const CONDITION_4 = '<';
    const CONDITION_5 = '<=';
    const CONDITION_6 = '!=';

    const ITEM_TYPE_ALIGN   = 'align';
    const ITEM_TYPE_BATTLE  = 'battle';
    const ITEM_TYPE_GENDER  = 'gender';
    const ITEM_TYPE_LEVEL   = 'level';
    const ITEM_TYPE_CUSTOM  = 'custom';

    public $condition;

    abstract public function getItemType();
    abstract public function getConditionString();

    public static function getConditions()
    {
        return [
            self::CONDITION_1 => 'Равно',
            self::CONDITION_2 => 'Больше',
            self::CONDITION_3 => 'Больше или равно',
            self::CONDITION_4 => 'Меньше',
            self::CONDITION_5 => 'Меньше или равно',
            self::CONDITION_6 => 'Не равно',
        ];
    }

    public static function getList()
    {
        return [
            self::ITEM_TYPE_ALIGN   => 'Склонность',
            self::ITEM_TYPE_BATTLE  => 'Бой',
            self::ITEM_TYPE_GENDER  => 'Пол',
            self::ITEM_TYPE_LEVEL   => 'Уровень',
            //self::ITEM_TYPE_CUSTOM  => 'Custom',
        ];
    }

    public static function getValidatorItemInfo($type)
    {
        $className = sprintf('frontend\models\questValidatorItemInfo\\Validator%s', ucfirst($type));
        try {
            return new $className();
        } catch (\Exception $ex) {
            return null;
        }
    }
}