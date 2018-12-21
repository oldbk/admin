<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 19.07.2016
 */

namespace common\models\questCondition;


use yii\helpers\ArrayHelper;

class QuestConditionMedal extends BaseCondition
{
    public $medal_key;
    public $medal_name;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['medal_key'], 'required'],
            [['medal_key', 'medal_name'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'medal_key' => 'Медаль',
        ];
    }

    public function getConditionType()
    {
        return self::TYPE_MEDAL;
    }

    public function getDescription()
    {
        return sprintf('Наличие медали: %s', $this->medal_name);
    }
}