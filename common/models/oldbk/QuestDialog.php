<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest_dialog".
 *
 * @property integer $id
 * @property integer $global_parent_id
 * @property integer $bot_id
 * @property integer $item_id
 * @property string $item_type
 * @property string $action_type
 * @property string $message
 * @property integer $is_saved
 * @property integer $order_position
 * @property integer $next_save_dialog
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $location
 */
class QuestDialog extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_dialog';
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
            [['global_parent_id', 'bot_id', 'action_type', 'message', 'order_position'], 'required'],
            [['global_parent_id', 'bot_id', 'is_saved', 'order_position', 'updated_at', 'created_at', 'next_save_dialog'], 'integer'],
            [['message'], 'string'],
            [['item_type', 'action_type', 'location'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'global_parent_id' => 'Global Parent ID',
            'bot_id' => 'Bot ID',
            'item_id' => 'Item ID',
            'item_type' => 'Item Type',
            'action_type' => 'Action Type',
            'message' => 'Message',
            'is_saved' => 'Is Saved',
            'order_position' => 'Order Position',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'location' => 'Локация',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestDialogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestDialogQuery(get_called_class());
    }
}
