<?php

namespace common\models\oldbk\pool;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pool".
 *
 * @property integer $id
 * @property string $target_type
 * @property integer $target_id
 * @property string $validator_type
 * @property integer $pool_id
 * @property integer $pocket_id
 * @property integer $created_at
 *
 *
 * @property PoolValidatorInfo[] $validatorInfo
 */
class PoolValidator extends \common\models\BaseModel
{
	const TARGET_POOL 			= 'pool';
	const TARGET_POCKET 		= 'pocket';
	const TARGET_POCKET_ITEM 	= 'pocket_item';

	const VALIDATOR_USER		= 'user';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pool_validator';
    }

	public static function getDb()
	{
		return \Yii::$app->get('db_oldbk');
	}

	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::class,
				'createdAtAttribute' => 'created_at',
			],
		];
	}

    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
			[['target_type', 'target_id', 'validator_type'], 'required'],
			[['target_id', 'created_at'], 'integer'],
			['target_type', 'in', 'range' => [self::TARGET_POOL, self::TARGET_POCKET, self::TARGET_POCKET_ITEM]],
			['validator_type', 'in', 'range' => [self::VALIDATOR_USER]],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' 				=> 'ID',
			'target_type' 		=> 'Тип связи',
			'target_id' 		=> 'ID связи',
			'validator_type' 	=> 'Тип сущности',
			'created_at' 		=> 'Создание',
		];
	}

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\pool\PoolValidatorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\pool\PoolValidatorQuery(get_called_class());
    }

    public function getValidatorInfo()
	{
		return $this->hasMany(PoolValidatorInfo::class, ['validator_id' => 'id']);
	}
}