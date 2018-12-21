<?php

namespace frontend\models\questValidatorItemInfo;

use Yii;

class ValidatorBattle extends BaseInfo
{
    public $battle_type;
    public $battle_comment;

    public function getItemType()
    {
        return self::ITEM_TYPE_BATTLE;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['condition'], 'required'],
            [['battle_type', 'battle_comment'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'condition'         => 'Условие',
            'battle_type'       => 'Тип боя',
            'battle_comment'    => 'Комментарий к бою',
        ];
    }

    public function getConditionString()
    {
        return sprintf('%s %s; Либо комментарий совпадает с "%s"', $this->condition, $this->battle_type, $this->battle_comment);
    }
}
