<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest_pocket".
 *
 * @property integer $id
 * @property integer $global_parent_id
 * @property integer $item_id
 * @property string $item_type
 * @property string $condition
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $dialog_finish_id
 */
class QuestPocket extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_pocket';
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
            [['item_id', 'item_type', 'condition', 'global_parent_id'], 'required'],
            [['item_id', 'updated_at', 'created_at', 'global_parent_id', 'dialog_finish_id'], 'integer'],
            [['item_type', 'condition'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'item_type' => 'Item Type',
            'condition' => 'Condition',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'dialog_finish_id' => 'Dialog finish id',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestPocketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestPocketQuery(get_called_class());
    }
}
