<?php

namespace frontend\models\questValidatorItemInfo;

use Yii;

class ValidatorCustom extends BaseInfo
{
    public $method_name;
    public $value;

    public function getItemType()
    {
        return self::ITEM_TYPE_CUSTOM;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['method_name', 'condition', 'value'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'method_name'   => 'Метод()',
            'condition'     => 'Условие',
            'value'         => 'Значение',
        ];
    }

    public function getConditionString()
    {
        return sprintf('Метод: %s. Условие: %s %s', $this->method_name, $this->condition, $this->value);
    }
}
