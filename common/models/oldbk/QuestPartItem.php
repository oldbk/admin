<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest_part_item".
 *
 * @property integer $id
 * @property integer $quest_id
 * @property integer $quest_part_id
 * @property string $name
 * @property integer $count
 * @property string $task
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $is_deleted
 *
 * @property QuestList $quest
 * @property QuestPart $questPart
 * @property UserQuestPartItem[] $userQuestPartItems
 */
class QuestPartItem extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_part_item';
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
            [['quest_id', 'quest_part_id', 'name'], 'required'],
            [['quest_id', 'quest_part_id', 'count', 'updated_at', 'created_at', 'is_deleted'], 'integer'],
            [['task'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['quest_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestList::className(), 'targetAttribute' => ['quest_id' => 'id']],
            [['quest_part_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestPart::className(), 'targetAttribute' => ['quest_part_id' => 'id']],
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
            'quest_part_id' => 'Quest Part ID',
            'name' => 'Name',
            'count' => 'Count',
            'task' => 'Task',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
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
    public function getQuestPart()
    {
        return $this->hasOne(QuestPart::className(), ['id' => 'quest_part_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuestPartItems()
    {
        return $this->hasMany(UserQuestPartItem::className(), ['quest_part_item_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestPartItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestPartItemQuery(get_called_class());
    }
}
