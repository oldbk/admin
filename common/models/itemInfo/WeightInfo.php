<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.03.2016
 */

namespace common\models\itemInfo;

use yii\helpers\ArrayHelper;

class WeightInfo extends BaseInfo
{
    public $event_id;

    public function getItemType()
    {
        return self::ITEM_TYPE_WEIGHT;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['event_id'], 'required']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'event_id' => 'Событие',
        ]);
    }

    public function getViewName()
    {
        return 'ВЕС';
    }

    public function getViewLink()
    {
        return 'javascript:void(0)';
    }
}