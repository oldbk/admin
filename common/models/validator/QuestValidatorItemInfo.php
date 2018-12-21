<?php

namespace common\models\validator;

use Yii;

/**
 * This is the model class for table "quest_validator_item_info".
 *
 * @property integer $item_id
 * @property string $field
 * @property string $value
 * @property string $validator_item_type
 * @property int $validator_parent_id
 * @property string $validator_parent_type
 *
 * @property QuestValidatorItem $item
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'field', 'value', 'validator_parent_id', 'validator_item_type', 'validator_parent_type'], 'required'],
            [['item_id', 'validator_parent_id'], 'integer'],
            [['value'], 'string'],
            [['field', 'validator_item_type', 'validator_parent_type'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestValidatorItem::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'field' => 'Field',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(QuestValidatorItem::className(), ['id' => 'item_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestValidatorItemInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\QuestValidatorItemInfoQuery(get_called_class());
    }
}
