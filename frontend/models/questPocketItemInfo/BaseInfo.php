<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 14.03.2016
 */

namespace frontend\models\questPocketItemInfo;


use yii\base\Model;

abstract class BaseInfo extends Model
{
    abstract public function getItemType();
    abstract public function getViewColumns();

    public static function getPocketItemInfo($type)
    {
        $className = sprintf('frontend\models\questPocketItemInfo\\Pocket%s', ucfirst($type));
        try {
            return new $className();
        } catch (\Exception $ex) {
            return null;
        }
    }
}