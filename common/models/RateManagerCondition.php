<?php

namespace common\models;


use common\models\rateCondition\BaseCondition;

/**
 * This is the model class for table "quest".
 *
 * @property integer $group
 * @property integer $rate_id
 * @property string $condition_type
 * @property string $field
 * @property string $value
 *
 */
class RateManagerCondition extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rate_manager_condition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group', 'rate_id', 'condition_type', 'field', 'value'], 'required'],
			[['group', 'rate_id'], 'integer'],
			[['field', 'value'], 'string', 'max' => 255],
			['condition_type', 'in', 'range' => [
				BaseCondition::TYPE_DATE,
				BaseCondition::TYPE_DATE_RANG,
				BaseCondition::TYPE_WEEK,
			]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'group' 			=> 'Группа',
			'rate_id' 			=> 'ID рейтинга',
            'condition_type' 	=> 'Тип условия',
            'field' 			=> 'Поле',
            'value' 			=> 'Значение',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\RateManagerConditionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\RateManagerConditionQuery(get_called_class());
    }
}
