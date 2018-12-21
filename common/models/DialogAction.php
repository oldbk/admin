<?php

namespace common\models;

use common\models\dialog\Dialog;
use Yii;

/**
 * This is the model class for table "quest_dialog_action".
 *
 * @property integer $id
 * @property integer $dialog_id
 * @property integer $global_parent_id
 * @property integer $item_id
 * @property string $item_type
 * @property integer $next_dialog_id
 * @property string $message
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property Dialog $dialog
 * @property Dialog $nextDialog
 */
class DialogAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dialog_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dialog_id'], 'required'],
            [['message', 'item_type'], 'string'],
            [['dialog_id', 'next_dialog_id', 'updated_at', 'created_at', 'item_id'], 'integer'],
            [['dialog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dialog::className(), 'targetAttribute' => ['dialog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dialog_id' => 'Диалог ID',
            'next_dialog_id' => 'Следующий диалог',
            'message' => 'Сообщение',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialog()
    {
        return $this->hasOne(Dialog::className(), ['id' => 'dialog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNextDialog()
    {
        return $this->hasOne(Dialog::className(), ['id' => 'next_dialog_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DialogActionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\DialogActionQuery(get_called_class());
    }
}
