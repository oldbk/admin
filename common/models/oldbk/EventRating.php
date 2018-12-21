<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "event_rating".
 *
 * @property integer $id
 * @property string $key
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $link
 * @property string $link_encicl
 * @property string $is_enabled
 * @property string $enable_type
 * @property integer $iteration_num
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $reward_till_days
 */
class EventRating extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_rating';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oldbk');
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
            [['key', 'name', 'reward_till_days', 'enable_type'], 'required'],
            [['iteration_num', 'updated_at', 'created_at', 'reward_till_days', 'is_enabled'], 'integer'],
			[['description'], 'string'],
			[['key', 'name', 'icon', 'link', 'link_encicl', 'enable_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\EventRatingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\EventRatingQuery(get_called_class());
    }
}
