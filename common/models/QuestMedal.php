<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "quest_medal".
 *
 * @property integer $id
 * @property string $key
 * @property string $name
 * @property int $day_count
 * @property integer $updated_at
 * @property integer $created_at
 */
class QuestMedal extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_medal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['key', 'unique'],
            [['key', 'name', 'day_count'], 'required'],
            [['updated_at', 'created_at', 'day_count'], 'integer'],
            [['key', 'name'], 'string', 'max' => 255],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Уникальный идентификатор',
            'name' => 'Название',
            'day_count' => 'Срок годности в дн.',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestMedalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\QuestMedalQuery(get_called_class());
    }
}
