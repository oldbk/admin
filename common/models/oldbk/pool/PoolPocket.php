<?php

namespace common\models\oldbk\pool;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pool".
 *
 * @property integer $id
 * @property integer $pool_id
 * @property string $description
 * @property string $condition
 * @property integer $updated_at
 * @property integer $created_at
 *
 *
 * @property PoolPocketItem[] $items
 * @property Pool $pool
 */
class PoolPocket extends \common\models\BaseModel
{
	const CONDITION_OR 	= 'or';
	const CONDITION_AND = 'and';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pool_pocket';
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
				'updatedAtAttribute' => 'updated_at',
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
			[['pool_id', 'description', 'condition'], 'required'],
			[['pool_id', 'updated_at', 'created_at'], 'integer'],
			[['description'], 'string'],
			['condition', 'in', 'range' => [self::CONDITION_AND, self::CONDITION_OR]],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' 			=> 'ID',
			'pool_id' 		=> 'Пул ID',
			'description' 	=> 'Описание',
			'condition' 	=> 'Условие',
			'updated_at' 	=> 'Обновление',
			'created_at' 	=> 'Создание',
		];
	}

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\pool\PoolPocketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\pool\PoolPocketQuery(get_called_class());
    }

	public function getItems()
	{
		return $this->hasMany(PoolPocketItem::class, ['pocket_id' => 'id']);
	}

	public function getPool()
	{
		return $this->hasOne(Pool::class, ['id' => 'pool_id']);
	}

	public static function getConditions()
	{
		return [
			self::CONDITION_OR 		=> 'OR',
			self::CONDITION_AND  	=> 'AND'
		];
	}
}