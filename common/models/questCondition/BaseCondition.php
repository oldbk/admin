<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\base\Model;

abstract class BaseCondition extends Model implements iCondition
{
    const TYPE_ITEM         = 'item';
    const TYPE_QUEST        = 'quest';
    const TYPE_MEDAL        = 'medal';
    const TYPE_LEVEL        = 'level';
    const TYPE_ALIGN        = 'align';
    const TYPE_DATE         = 'date';
    const TYPE_PROF         = 'prof';
    const TYPE_COUNT        = 'count';
    const TYPE_WEEK        	= 'week';
    const TYPE_GENDER       = 'gender';

    /**
     * @param $type
     * @return iCondition
     * @throws \Exception
     */
    public static function createInstance($type)
    {
        $className = sprintf('\\common\\models\\questCondition\\QuestCondition%s', ucfirst($type));
        try {
            return new $className;
        } catch (\Exception $ex) {
            throw new \Exception(sprintf('Cannot find class %s', $className));
        }
    }

    /*public function getAttributeLabel($attribute)
    {
        var_dump($attribute);die;
    }*/
}