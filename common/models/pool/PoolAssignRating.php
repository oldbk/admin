<?php

namespace common\models\pool;

/**
 * This is the model class for table "pool".
 *
 * @property integer $pool_assign_id
 * @property integer $rating_id
 * @property integer $min_position
 * @property integer $max_position
 * @property integer $updated_at
 * @property integer $created_at
 *
 *
 * @property Pool $pool
 */
class PoolAssignRating extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pool_assign_rating';
    }

    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
			[['pool_assign_id', 'rating_id', 'min_position', 'max_position'], 'required'],
			[['pool_assign_id', 'rating_id', 'min_position', 'max_position'], 'integer'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'pool_assign_id' 	=> 'ID связи',
			'rating_id' 		=> 'ID рейтинга',
			'min_position' 		=> 'Мин. позиция',
			'max_position' 		=> 'Макс. позиция',
		];
	}

    /**
     * @inheritdoc
     * @return \common\models\query\pool\PoolAssignRatingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\pool\PoolAssignRatingQuery(get_called_class());
    }
}