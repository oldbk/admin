<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "quest_validator_item_info".
 *
 * @property integer $item_id
 * @property string $field
 * @property string $value
 * @property string $validator_item_type
 * @property integer $validator_parent_id
 * @property string $validator_parent_type
 * @property integer $global_parent_id
 */
class QuestValidatorItemInfo extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_validator_item_info';
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
            [['item_id', 'field', 'value', 'validator_parent_id', 'global_parent_id'], 'required'],
            [['item_id', 'validator_parent_id', 'global_parent_id'], 'integer'],
            [['value'], 'string'],
            [['field', 'validator_item_type', 'validator_parent_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' 				=> 'Item ID',
            'field' 				=> 'Field',
            'value' 				=> 'Value',
            'validator_item_type' => 'Validator Item Type',
            'validator_parent_id' => 'Validator Parent ID',
            'validator_parent_type' => 'Validator Parent Type',
            'global_parent_id' => 'Quest ID',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestValidatorItemInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestValidatorItemInfoQuery(get_called_class());
    }
}
