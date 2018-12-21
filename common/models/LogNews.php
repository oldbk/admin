<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "log_news".
 *
 * @property integer $id
 * @property integer $news_id
 * @property integer $user_id
 * @property string $operation
 * @property integer $created_at
 */
class LogNews extends \yii\db\ActiveRecord
{
    const OPERATION_CREATE = 'create';
    const OPERATION_UPDATE = 'update';
    const OPERATION_DELETE = 'delete';
    const OPERATION_ENABLE = 'enable';
    const OPERATION_DISABLE = 'disable';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_news';
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
            [['news_id', 'user_id', 'operation'], 'required'],
            [['news_id', 'user_id', 'created_at'], 'integer'],
            [['operation'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'user_id' => 'User ID',
            'operation' => 'Operation',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\LogNewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\LogNewsQuery(get_called_class());
    }
}
