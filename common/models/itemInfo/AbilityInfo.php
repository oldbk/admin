<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.03.2016
 */

namespace common\models\itemInfo;

use yii\helpers\ArrayHelper;

class AbilityInfo extends BaseInfo
{
    public $magic_id;

    public function getItemType()
    {
        return self::ITEM_TYPE_ABILITY_OWN;
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['magic_id'], 'required'],
            [['magic_id'], 'safe'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'name' => 'Название абилки',
        ]);
    }

    public function getViewName()
    {
        return $this->name;
    }
    
    public function getViewLink()
    {
        return 'javascript:void(0)';
    }
}