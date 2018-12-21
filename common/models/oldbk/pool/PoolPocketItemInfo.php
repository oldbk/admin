<?php

namespace common\models\oldbk\pool;

/**
 * This is the model class for table "pool".
 *
 * @property integer $pocket_item_id
 * @property string $field
 * @property string $value
 * @property integer $pool_id
 * @property integer $pocket_id
 *
 */
class PoolPocketItemInfo extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pool_pocket_item_info';
    }

	public static function getDb()
	{
		return \Yii::$app->get('db_oldbk');
	}

    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
			[['pocket_item_id', 'field', 'value', 'pool_id', 'pocket_id'], 'required'],
			[['pocket_item_id', 'pool_id', 'pocket_id'], 'integer'],
			[['field', 'value'], 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' 				=> 'ID',
			'pool_id' 			=> 'ID пула',
			'pocket_id' 		=> 'ID пакета',
			'pocket_item_id' 	=> 'ID сущности',
			'field' 			=> 'Поле',
			'value' 			=> 'Значение',
		];
	}

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\pool\PoolPocketItemInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\pool\PoolPocketItemInfoQuery(get_called_class());
    }
}