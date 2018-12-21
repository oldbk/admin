<?php

namespace common\models;

use common\models\dialog\Dialog;
use Yii;

/**
 * This is the model class for table "dialog_bot".
 *
 * @property integer $id
 * @property string $bot_key
 * @property string $name
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property Dialog[] $questDialogs
 */
class DialogBot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dialog_bot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bot_key'], 'required'],
            [['updated_at', 'created_at'], 'integer'],
            [['bot_key'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bot_key' => 'Bot Key',
            'name' => 'Name',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestDialogs()
    {
        return $this->hasMany(Dialog::className(), ['bot_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DialogBotQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DialogBotQuery(get_called_class());
    }
}
