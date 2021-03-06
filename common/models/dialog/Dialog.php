<?php

namespace common\models\dialog;

use common\models\BaseModel;
use common\models\DialogBot;
use common\models\DialogAction;
use common\models\query\DialogQuery;
use Yii;

/**
 * This is the model class for table "quest_dialog".
 *
 * @property integer $id
 * @property integer $global_parent_id
 * @property integer $bot_id
 * @property integer $item_id
 * @property string $item_type
 * @property string $action_type
 * @property string $name
 * @property string $message
 * @property integer $is_saved
 * @property integer $order_position
 * @property integer $next_save_dialog
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $location
 *
 * @property DialogBot $bot
 * @property DialogAction[] $questDialogActions
 */
class Dialog extends BaseModel
{
    const ACTION_QUEST_START        = 'quest_start';
    const ACTION_QUEST_END          = 'quest_end';
    const ACTION_PART_START         = 'part_start';
    const ACTION_PART_CHECK_FINISH  = 'part_check_finish';
    const ACTION_PART_END           = 'part_end';
    const ACTION_PART_NEXT_START    = 'part_next_start';
    const ACTION_TASK_CHECK         = 'task_check';
    const ACTION_DIALOG             = 'dialog';

    const TYPE_QUEST    = 'quest';
    const TYPE_PART     = 'part';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dialog';
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if($this->scenario != self::SCENARIO_SEARCH) {
            $this->order_position = 1;
        }
    }

    public static function instantiate($row)
    {
        return static::getInstance($row['item_type']);
    }

    /**
     * @param $item_type
     * @return DialogPart|DialogQuest
     * @throws \Exception
     */
    public static function getInstance($item_type)
    {
        switch ($item_type) {
            case self::TYPE_QUEST:
                return new DialogQuest();
                break;
            case self::TYPE_PART:
                return new DialogPart();
                break;
        }

        throw new \Exception('Вид диалога не найден', 420);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['order_position'], 'unique', 'targetAttribute' => ['global_parent_id', 'order_position']],
            [['bot_id', 'action_type', 'message', 'order_position', 'global_parent_id'], 'required'],
            [['bot_id', 'item_id', 'is_saved', 'updated_at', 'created_at', 'order_position', 'global_parent_id', 'next_save_dialog'], 'integer'],
            [['message'], 'string'],
            [['item_type', 'action_type', 'location'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 50],
            [['bot_id'], 'exist', 'skipOnError' => true, 'targetClass' => DialogBot::className(), 'targetAttribute' => ['bot_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bot_id' => 'Бот',
            'item_id' => 'Item ID',
            'item_type' => 'Item Type',
            'action_type' => 'Действие',
            'message' => 'Сообщение',
            'name' => 'Название',
            'is_saved' => 'Точка сохранения?',
            'order_position' => 'Позиция',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'location' => 'Локация',
            'next_save_dialog' => 'Следующий диалог',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBot()
    {
        return $this->hasOne(DialogBot::className(), ['id' => 'bot_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestDialogActions()
    {
        return $this->hasMany(DialogAction::className(), ['dialog_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\DialogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DialogQuery(get_called_class());
    }

    public static function getActions()
    {
        return [
            self::ACTION_DIALOG             => 'Диалог',
            self::ACTION_QUEST_START        => 'Старт квеста',
            self::ACTION_QUEST_END          => 'Завершение квеста',

            self::ACTION_PART_START         => 'Старт части',
            self::ACTION_PART_END           => 'Завершение части',
            self::ACTION_PART_CHECK_FINISH  => 'Чек и завершение части (не завершает квест)',
            self::ACTION_PART_NEXT_START    => 'Завершить текущую и запустить следующую часть',

            self::ACTION_TASK_CHECK         => 'Чек задания',
        ];
    }
}
