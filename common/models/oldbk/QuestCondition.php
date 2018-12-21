<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "quest_condition".
 *
 * @property integer $group
 * @property integer $item_id
 * @property string $item_type
 * @property string $condition_type
 * @property string $field
 * @property string $value
 */
class QuestCondition extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_condition';
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
            [['item_id', 'item_type', 'condition_type', 'field', 'value'], 'required'],
            [['item_id'], 'integer'],
            [['condition_type', 'field', 'value', 'item_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Quest ID',
            'condition_type' => 'Condition Type',
            'field' => 'Field',
            'value' => 'Value',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestConditionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestConditionQuery(get_called_class());
    }
}
