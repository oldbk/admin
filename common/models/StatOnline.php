<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stat_online".
 *
 * @property integer $datetime
 * @property string $count
 * @property integer $updated_at
 */
class StatOnline extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat_online';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime'], 'required'],
            [['datetime', 'updated_at'], 'integer'],
            [['count'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'datetime' => 'Datetime',
            'count' => 'Count',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return StatOnlineQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatOnlineQuery(get_called_class());
    }
}
