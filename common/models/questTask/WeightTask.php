<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 31.05.2016
 */

namespace common\models\questTask;


use yii\helpers\ArrayHelper;

class WeightTask extends BaseTask
{
    public $event_id;
    public $event_name;

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['event_id'],'required'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'event_id' => 'Событие',
        ]);
    }

    public function getItemType()
    {
        return self::ITEM_TYPE_WEIGHT;
    }

    public function getViewName()
    {
        return sprintf('Событие: %s', $this->event_name);
    }

    public function setEventName($name)
    {
        $this->event_name = $name;
        return $this;
    }
}