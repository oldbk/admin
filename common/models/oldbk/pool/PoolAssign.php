<?php

namespace common\models\oldbk\pool;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pool".
 *
 * @property integer $id
 * @property integer $pool_id
 * @property string $target_type
 * @property integer $target_id
 * @property string $target_name
 * @property integer $updated_at
 * @property integer $created_at
 *
 *
 * @property Pool $pool
 * @property PoolAssignRating $assignRating
 */
class PoolAssign extends \common\models\BaseModel
{
	const TARGET_RATE = 'rate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pool_assign';
    }

	public static function getDb()
	{
		return \Yii::$app->get('db_oldbk');
	}

	public function behaviors()
	{
		return [
			[
				'class' => TimestampBehavior::className(),
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
			[['pool_id', 'target_type', 'target_id', 'target_name'], 'required'],
			[['pool_id', 'target_id', 'updated_at', 'created_at'], 'integer'],
			[['target_name'], 'string', 'max' => 255],
			['target_type', 'in', 'range' => [self::TARGET_RATE]]
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
			'target_type' 	=> 'Тип связи',
			'target_id' 	=> 'ID связи',
			'target_name' 	=> 'Название связи',
			'updated_at' 	=> 'Обновление',
			'created_at' 	=> 'Создание',
		];
	}

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\pool\PoolAssignQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\pool\PoolAssignQuery(get_called_class());
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPool()
	{
		return $this->hasOne(Pool::class, ['id' => 'pool_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAssignRating()
	{
		return $this->hasOne(PoolAssignRating::class, ['pool_assign_id' => 'id']);
	}
}