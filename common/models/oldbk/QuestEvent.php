<?php

namespace common\models\oldbk;

use Yii;

/**
 * This is the model class for table "quest_event".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $quest_ids
 * @property integer $is_enabled
 */
class QuestEvent extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_event';
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
            [['description'], 'required'],
            [['description'], 'string'],
            [['is_enabled'], 'integer'],
            [['name', 'quest_ids'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'quest_ids' => 'Quest Ids',
            'is_enabled' => 'Is Enabled',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\query\QuestEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\oldbk\query\QuestEventQuery(get_called_class());
    }
}
