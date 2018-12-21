<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "quest_validator_item".
 *
 * @property integer $id
 * @property string $item_type
 * @property integer $parent_id
 * @property string $parent_type
 * @property integer $global_parent_id
 */
class QuestValidatorItem extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_validator_item';
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
            [['id', 'parent_id', 'global_parent_id'], 'required'],
            [['id', 'parent_id', 'global_parent_id'], 'integer'],
            [['item_type', 'parent_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_type' => 'Item Type',
            'parent_id' => 'Parent ID',
            'parent_type' => 'Parent Type',
            'global_parent_id' => 'Quest ID',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestValidatorItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestValidatorItemQuery(get_called_class());
    }
}
