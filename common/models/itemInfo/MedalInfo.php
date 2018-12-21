<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.03.2016
 */

namespace common\models\itemInfo;

use yii\helpers\ArrayHelper;

class MedalInfo extends BaseInfo
{
    public $medal_stage_1;
    public $medal_stage_2;
    public $medal_stage_3;
    public $medal_stage_4;
    public $medal_stage_5;

    public $medal_stage_1_title;
    public $medal_stage_2_title;
    public $medal_stage_3_title;
    public $medal_stage_4_title;
    public $medal_stage_5_title;

    public $medal_key;

    public $medal_id;

    public $day = 0;

    public function getItemType()
    {
        return self::ITEM_TYPE_MEDAL;
    }

    public function rules()
    {
        return ArrayHelper::merge( parent::rules(), [
            [['medal_key'], 'required'],
            [['medal_stage_1', 'medal_stage_2', 'medal_stage_3', 'medal_stage_4', 'medal_stage_5', 'medal_key', 'medal_id'], 'safe'],
            [['medal_stage_1_title', 'medal_stage_2_title', 'medal_stage_3_title', 'medal_stage_4_title', 'medal_stage_5_title'], 'safe'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge( parent::attributeLabels(), [
            'medal_key'     => 'Медаль',
            'medal_stage_1' => 'Изображение 1',
            'medal_stage_1_title' => 'Название 1',
            'medal_stage_2' => 'Изображение 2',
            'medal_stage_2_title' => 'Название 2',
            'medal_stage_3' => 'Изображение 3',
            'medal_stage_3_title' => 'Название 3',
            'medal_stage_4' => 'Изображение 4',
            'medal_stage_4_title' => 'Название 4',
            'medal_stage_5' => 'Изображение 5',
            'medal_stage_5_title' => 'Название 5',
        ]);
    }

    public function getViewName()
    {
        return 'Медаль ('.$this->medal_key.')';
    }

    public function getViewLink()
    {
        return 'javascript:void(0)';
    }
}