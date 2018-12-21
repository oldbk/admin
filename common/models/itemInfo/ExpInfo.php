<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.03.2016
 */

namespace common\models\itemInfo;

class ExpInfo extends BaseInfo
{
    public function getItemType()
    {
        return self::ITEM_TYPE_EXP;
    }

    public function rules()
    {
        return parent::rules();
    }

    public function getViewName()
    {
        return 'Опыт';
    }

    public function getViewLink()
    {
        return 'javascript:void(0)';
    }
}