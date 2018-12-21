<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "quest_item_info".
 *
 * @property integer $item_id
 * @property string $field
 * @property string $value
 * @property integer $global_parent_id
 * @property integer $pocket_id
 * @property integer $pocket_item_id
 * @property string $pocket_item_type
 */
class QuestPocketItemInfo extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_pocket_item_info';
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
            [['item_id', 'field', 'value', 'pocket_item_id', 'pocket_item_type', 'pocket_id', 'global_parent_id'], 'required'],
            [['item_id', 'pocket_item_id', 'pocket_id', 'global_parent_id'], 'integer'],
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
            'pocket_item_id' => 'Single ID',
            'pocket_item_type' => 'Single Type',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestItemInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestItemInfoQuery(get_called_class());
    }
}
