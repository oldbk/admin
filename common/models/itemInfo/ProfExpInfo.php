<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.03.2016
 */

namespace common\models\itemInfo;

use yii\helpers\ArrayHelper;

class ProfExpInfo extends BaseInfo
{
    public $profession_id;
    public $profession_name;

    public function getItemType()
    {
        return self::ITEM_TYPE_PROF_EXP;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['profession_id'], 'required']
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'profession_id' => 'Профессия',
        ]);
    }

    public function getViewName()
    {
        return $this->profession_name;
    }

    public function getViewLink()
    {
        return 'javascript:void(0)';
    }
}