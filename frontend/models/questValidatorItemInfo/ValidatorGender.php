<?php

namespace frontend\models\questValidatorItemInfo;

use Yii;

class ValidatorGender extends BaseInfo
{
    public $value;

    public function getItemType()
    {
        return self::ITEM_TYPE_GENDER;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['condition', 'value'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'condition' => 'Условие',
            'value'     => 'Пол',
        ];
    }

    public function getConditionString()
    {
        return sprintf('%s %s', $this->condition, $this->value);
    }
}
