<?php

namespace common\models\pool;

use common\models\RateManager;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pool".
 *
 * @property integer $id
 * @property string $name
 * @property integer $updated_at
 * @property integer $created_at
 *
 *
 * @property PoolPocket[] $pockets
 * @property PoolAssign[] $assigns
 * @property RateManager[] $ratings
 */
class Pool extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pool';
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
			[['name'], 'required'],
			[['updated_at', 'created_at'], 'integer'],
			[['name'], 'string', 'max' => 255],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' 			=> 'ID',
			'name' 			=> 'Название',
			'updated_at' 	=> 'Обновление',
			'created_at' 	=> 'Создание',
		];
	}

    /**
     * @inheritdoc
     * @return \common\models\query\pool\PoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\pool\PoolQuery(get_called_class());
    }

	public function getPockets()
	{
		return $this->hasMany(PoolPocket::class, ['pool_id' => 'id']);
	}

	public function getAssigns()
	{
		return $this->hasMany(PoolAssign::class, ['pool_id' => 'id'])->alias('assigns');
	}

	public function getRatings()
	{
		return $this->hasMany(RateManager::class, ['id' => 'target_id'])->via('assigns', function($q) {
			$q->andWhere(['=', 'assigns.target_type', PoolAssign::TARGET_RATE]);
		});
	}
}