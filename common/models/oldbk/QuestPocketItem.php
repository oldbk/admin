<?php

namespace common\models\oldbk;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest_item".
 *
 * @property integer $id
 * @property integer $global_parent_id
 * @property integer $pocket_id
 * @property integer $pocket_item_id
 * @property string $pocket_item_type
 * @property string $item_type
 * @property integer $count
 * @property integer $updated_at
 * @property integer $created_at
 */
class QuestPocketItem extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_pocket_item';
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
            [['pocket_item_id', 'pocket_item_type', 'item_type', 'count', 'pocket_id', 'global_parent_id'], 'required'],
            [['pocket_item_id', 'count', 'updated_at', 'created_at', 'pocket_id', 'global_parent_id'], 'integer'],
            [['pocket_item_type', 'item_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pocket_item_id' => 'Single ID',
            'pocket_item_type' => 'Single Type',
            'item_type' => 'Item Type',
            'count' => 'Count',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestItemQuery(get_called_class());
    }
}
