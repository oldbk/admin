<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "user_quest_part_item".
 *
 * @property integer $id
 * @property integer $user_quest_id
 * @property integer $user_quest_part_id
 * @property integer $quest_id
 * @property integer $quest_part_id
 * @property integer $user_id
 * @property integer $item_id
 * @property integer $count
 * @property integer $need_count
 * @property integer $ended_at
 * @property integer $is_finished
 */
class UserQuestPartItem extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_quest_part_item';
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
            [['user_quest_id', 'user_quest_part_id', 'quest_id', 'quest_part_id', 'user_id', 'item_id', 'need_count'], 'required'],
            [['user_quest_id', 'user_quest_part_id', 'quest_id', 'quest_part_id', 'user_id', 'item_id', 'count', 'need_count', 'ended_at', 'is_finished'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_quest_id' => 'User Quest ID',
            'user_quest_part_id' => 'User Quest Part ID',
            'quest_id' => 'Quest ID',
            'quest_part_id' => 'Quest Part ID',
            'user_id' => 'User ID',
            'item_id' => 'Item ID',
            'count' => 'Count',
            'need_count' => 'Need Count',
            'ended_at' => 'Ended At',
            'is_finished' => 'Is Finished',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\UserQuestPartItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\UserQuestPartItemQuery(get_called_class());
    }
}
