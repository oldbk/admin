<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cron_log".
 *
 * @property integer $id
 * @property string $command
 * @property integer $status
 * @property string $message
 * @property string $trace
 * @property integer $code
 * @property integer $created_at
 */
class CronLog extends \yii\db\ActiveRecord
{
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cron_log';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['command', 'status'], 'required'],
            [['status', 'code', 'created_at'], 'integer'],
            [['message', 'trace'], 'string'],
            [['command'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'command' => 'Command',
            'status' => 'Status',
            'message' => 'Message',
            'trace' => 'Trace',
            'code' => 'Code',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\CronLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CronLogQuery(get_called_class());
    }
}
