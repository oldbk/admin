<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest_part".
 *
 * @property integer $id
 * @property integer $quest_id
 * @property string $name
 * @property string $img
 * @property string $description_type
 * @property string $description_data
 * @property string $part_gift
 * @property string $chat_start
 * @property string $chat_end
 * @property integer $is_auto_finish
 * @property integer $part_number
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $is_deleted
 * @property integer $is_auto_start
 * @property integer $weight
 * @property string $complete_condition_message
 *
 * @property QuestList $quest
 * @property QuestPartItem[] $questPartItems
 * @property UserQuestPart[] $userQuestParts
 * @property UserQuestPartItem[] $userQuestPartItems
 */
class QuestPart extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_part';
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
                'class' => TimestampBehavior::className(),
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
            [['quest_id', 'is_auto_finish', 'part_number', 'updated_at', 'created_at', 'is_deleted', 'is_auto_start', 'weight'], 'integer'],
            [['name', 'description_type', 'part_number'], 'required'],
            [['img', 'description_data', 'part_gift', 'chat_start', 'chat_end', 'complete_condition_message'], 'string'],
            [['name', 'description_type'], 'string', 'max' => 255],
            [['quest_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestList::className(), 'targetAttribute' => ['quest_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quest_id' => 'Quest ID',
            'name' => 'Name',
            'img' => 'Img',
            'description_type' => 'Description Type',
            'description_data' => 'Description Data',
            'part_gift' => 'Part Gift',
            'chat_start' => 'Chat Start',
            'chat_end' => 'Chat End',
            'is_auto_finish' => 'Is Auto Finish',
            'part_number' => 'Part Number',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'weight' => 'Вес',
            'complete_condition_message' => 'Сообщение о выполнении всех условий квеста'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuest()
    {
        return $this->hasOne(QuestList::className(), ['id' => 'quest_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestPartItems()
    {
        return $this->hasMany(QuestPartItem::className(), ['quest_part_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuestParts()
    {
        return $this->hasMany(UserQuestPart::className(), ['quest_part_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuestPartItems()
    {
        return $this->hasMany(UserQuestPartItem::className(), ['quest_part_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestPartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestPartQuery(get_called_class());
    }
}
