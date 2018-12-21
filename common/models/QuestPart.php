<?php

namespace common\models;

use common\models\query\QuestPartQuery;
use common\models\query\QuestPocketQuery;
use common\models\questPocket\QuestPocketPartReward;
use common\models\questPocket\QuestPocketPartTake;
use common\models\questPocket\QuestPocketPartTask;
use common\models\questPocket\QuestPocketPartValidate;
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
 * @property string $description
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
 * @property Quest $quest
 * @property QuestPocketPartTask[] $pocketTasks
 * @property QuestPocketPartReward[] $pocketRewards
 * @property QuestPocketPartTake[] $pocketTakes
 * @property QuestPocketPartValidate[] $pocketValidates
 */
class QuestPart extends BaseModel
{
    const DESCRIPTION_TYPE_TASK         = 'task';
    const DESCRIPTION_TYPE_INVENTORY    = 'inventory';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_part';
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
            [['quest_id', 'name', 'description_type', 'part_number'], 'required'],
            [['quest_id', 'is_auto_finish', 'part_number', 'updated_at', 'created_at', 'is_deleted', 'is_auto_start', 'weight'], 'integer'],
            [['img', 'description', 'chat_start', 'chat_end', 'complete_condition_message'], 'string'],
            [['name', 'description_type'], 'string', 'max' => 255],
            [['quest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quest::className(), 'targetAttribute' => ['quest_id' => 'id']],
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
            'name' => 'Название',
            'img' => 'Img',
            'description_type' => 'Тип состояния',
            'description' => 'Текст состояния',
            'chat_start' => 'Стартовое сообщение в чат',
            'chat_end' => 'Завершающее сообщение в чат',
            'is_auto_finish' => 'Авто-завершение',
            'part_number' => 'Порядок',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'is_deleted' => 'Is Deleted',
            'is_auto_start' => 'Авто-старт',
            'weight'        => 'Вес',
            'complete_condition_message' => 'Сообщение о выполнении всех условий квеста'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuest()
    {
        return $this->hasOne(Quest::className(), ['id' => 'quest_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestPartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestPartQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPocketTasks()
    {
        return $this->hasMany(QuestPocketPartTask::className(), ['item_id' => 'id']);
    }

    /**
     * @return QuestPocketQuery
     */
    public function getPocketRewards()
    {
        return $this->hasMany(QuestPocketPartReward::className(), ['item_id' => 'id']);
    }

    /**
     * @return QuestPocketQuery
     */
    public function getPocketTakes()
    {
        return $this->hasMany(QuestPocketPartTake::className(), ['item_id' => 'id']);
    }

    /**
     * @return QuestPocketQuery
     */
    public function getPocketValidates()
    {
        return $this->hasMany(QuestPocketPartValidate::className(), ['item_id' => 'id']);
    }


    public static function getDescriptionTypes()
    {
        return [
            self::DESCRIPTION_TYPE_TASK      => 'Задания',
            self::DESCRIPTION_TYPE_INVENTORY => 'Инвентарь',
        ];
    }

    /**
     * @param $quest_id
     * @return array
     * @deprecated
     */
    public static function prettySelect($quest_id)
    {
        $result = [];
        $QuestPartList = QuestPart::find()
            ->select(['name', 'id'])
            ->where(['quest_id' => $quest_id])
            ->all();

        foreach ($QuestPartList as $Item) {
            $result[$Item['id']] = sprintf('ID: %d. %s', $Item['id'], $Item['name']);
        }

        return $result;
    }
}
