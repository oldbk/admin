<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "event_rating".
 *
 * @property integer $group
 * @property integer $rate_id
 * @property string $condition_type
 * @property string $field
 * @property string $value
 */
class EventRatingCondition extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_rating_condition';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_oldbk');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group', 'rate_id', 'condition_type', 'field', 'value'], 'required'],
            [['group', 'rate_id'], 'integer'],
			[['field', 'value', 'condition_type'], 'string', 'max' => 255],
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
     * @return \common\models\oldbk\query\EventRatingConditionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\EventRatingConditionQuery(get_called_class());
    }
}
