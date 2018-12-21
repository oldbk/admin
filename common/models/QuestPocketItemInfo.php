<?php

namespace common\models;

use common\models\query\QuestPocketItemInfoQuery;
use Yii;

/**
 * This is the model class for table "quest_pocket_item_info".
 *
 * @property integer $item_id
 * @property string $field
 * @property string $value
 * @property integer $pocket_id
 * @property integer $pocket_item_id
 * @property string $pocket_item_type
 */
class QuestPocketItemInfo extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_pocket_item_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'field', 'value', 'pocket_id', 'pocket_item_id', 'pocket_item_type'], 'required'],
            [['item_id', 'pocket_id', 'pocket_item_id'], 'integer'],
            [['field', 'value', 'pocket_item_type'], 'string', 'max' => 255],
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
            'pocket_id' => 'Pocket ID',
            'pocket_item_id' => 'Pocket Item ID',
            'pocket_item_type' => 'Pocket Item Type',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestPocketItemInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestPocketItemInfoQuery(get_called_class());
    }
}
