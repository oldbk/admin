<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest_list".
 *
 * @property integer $id
 * @property string $quest_type
 * @property string $name
 * @property integer $started_at
 * @property integer $ended_at
 * @property integer $min_level
 * @property integer $max_level
 * @property integer $limit_count
 * @property integer $limit_interval
 * @property integer $is_enabled
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $is_deleted
 * @property integer $is_canceled
 *
 * @property QuestBotList[] $questBotLists
 * @property QuestPart[] $questParts
 * @property QuestPartItem[] $questPartItems
 * @property QuestUserItems[] $questUserItems
 * @property UserQuest[] $userQuests
 * @property UserQuestPart[] $userQuestParts
 * @property UserQuestPartItem[] $userQuestPartItems
 */
class QuestList extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_list';
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
            [['quest_type', 'name', 'min_level', 'max_level'], 'required'],
            [['started_at', 'ended_at', 'min_level', 'max_level', 'limit_count', 'limit_interval',
                'is_enabled', 'updated_at', 'created_at', 'is_deleted', 'is_canceled'], 'integer'],
            [['quest_type', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quest_type' => 'Quest Type',
            'name' => 'Name',
            'started_at' => 'Started At',
            'ended_at' => 'Ended At',
            'min_level' => 'Min Level',
            'max_level' => 'Max Level',
            'limit_count' => 'Limit Count',
            'limit_interval' => 'Limit Interval',
            'is_enabled' => 'Is Enabled',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestBotLists()
    {
        return $this->hasMany(QuestBotList::className(), ['quest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestParts()
    {
        return $this->hasMany(QuestPart::className(), ['quest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestPartItems()
    {
        return $this->hasMany(QuestPartItem::className(), ['quest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestUserItems()
    {
        return $this->hasMany(QuestUserItems::className(), ['quest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuests()
    {
        return $this->hasMany(UserQuest::className(), ['quest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuestParts()
    {
        return $this->hasMany(UserQuestPart::className(), ['quest_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserQuestPartItems()
    {
        return $this->hasMany(UserQuestPartItem::className(), ['quest_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestListQuery(get_called_class());
    }
}
