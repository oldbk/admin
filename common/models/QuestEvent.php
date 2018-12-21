<?php

namespace common\models;

use common\models\query\QuestEventQuery;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $quest_ids
 * @property integer $is_enabled
 * @property integer $updated_at
 * @property integer $created_at
 */
class QuestEvent extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_event';
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
            [['name', 'description', 'quest_ids'], 'required'],
            [['updated_at', 'created_at', 'is_enabled'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание (в состоянии)',
            'quest_ids' => 'IDs квестов события',
            'is_enabled' => 'Выключено?',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestEventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestEventQuery(get_called_class());
    }
}
