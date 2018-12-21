<?php

namespace common\models\pool;

/**
 * This is the model class for table "pool".
 *
 * @property integer $validator_id
 * @property string $field
 * @property string $value
 * @property string $target_type
 * @property integer $target_id
 * @property integer $pool_id
 * @property integer $pocket_id
 *
 */
class PoolValidatorInfo extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pool_validator_info';
    }

    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
			[['validator_id', 'field', 'value', 'pool_id', 'target_type', 'target_id'], 'required'],
			[['validator_id', 'pool_id', 'target_id'], 'integer'],
			[['field', 'value'], 'string', 'max' => 255],
			['target_type', 'in', 'range' => [PoolValidator::TARGET_POOL, PoolValidator::TARGET_POCKET, PoolValidator::TARGET_POCKET_ITEM]],
			[['validator_id', 'field'], 'unique'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'validator_id' 	=> 'ID валидатора',
			'field' 		=> 'Поле',
			'value' 		=> 'Значение',
			'pool_id' 		=> 'ID пула',
			'target_type' 	=> 'Тип связи',
			'target_id' 	=> 'ID связи',
		];
	}

    /**
     * @inheritdoc
     * @return \common\models\query\pool\PoolValidatorInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\pool\PoolValidatorInfoQuery(get_called_class());
    }
}