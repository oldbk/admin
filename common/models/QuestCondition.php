<?php

namespace common\models;

use common\models\query\QuestConditionQuery;
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
 *
 * @property Quest $quest
 *
 * @method QuestConditionQuery hasOne($className, $params)
 */
class QuestCondition extends \common\models\BaseModel
{
    const ITEM_TYPE_QUEST = 'quest';
    const ITEM_TYPE_PART = 'part';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_condition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group', 'item_id', 'field', 'value', 'condition_type'], 'required'],
            [['item_id'], 'integer'],
            [['field', 'value', 'condition_type'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quest::className(), 'targetAttribute' => ['item_id' => 'id']],
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
    public function getQuest()
    {
        return $this->hasOne(Quest::className(), ['id' => 'item_id'])
            ->quest();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestPart()
    {
        return $this->hasOne(Quest::className(), ['id' => 'item_id'])
            ->part();
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestConditionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestConditionQuery(get_called_class());
    }
}
