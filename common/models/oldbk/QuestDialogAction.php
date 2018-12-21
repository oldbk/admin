<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest_dialog_action".
 *
 * @property integer $id
 * @property integer $global_parent_id
 * @property integer $dialog_id
 * @property integer $item_id
 * @property string $item_type
 * @property integer $next_dialog_id
 * @property string $message
 * @property integer $updated_at
 * @property integer $created_at
 */
class QuestDialogAction extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_dialog_action';
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
            [['id', 'dialog_id', 'message', 'global_parent_id'], 'required'],
            [['id', 'dialog_id', 'item_id', 'next_dialog_id', 'updated_at', 'created_at', 'global_parent_id'], 'integer'],
            [['message'], 'string'],
            [['item_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dialog_id' => 'Dialog ID',
            'item_id' => 'Item ID',
            'item_type' => 'Item Type',
            'next_dialog_id' => 'Next Dialog ID',
            'message' => 'Message',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestDialogActionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestDialogActionQuery(get_called_class());
    }
}
