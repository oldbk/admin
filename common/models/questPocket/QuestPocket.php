<?php

namespace common\models\questPocket;

use common\models\BaseModel;
use common\models\oldbk\QuestPart;
use common\models\query\QuestPocketQuery;
use common\models\QuestPocketItem;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Class QuestPocket
 * @package common\models\questPocket
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $item_type
 * @property string $name
 * @property string $condition
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $dialog_finish_id
 *
 *
 * @property QuestPocketItem[] $pocketItems
 * @property QuestPart $part
 */
class QuestPocket extends BaseModel
{
    const TYPE_AND  = 'and';
    const TYPE_OR   = 'or';

    const TYPE_PART_REWARD      = 'part_reward';
    const TYPE_PART_VALIDATE    = 'part_validate';
    const TYPE_PART_TASK        = 'part_task';
    const TYPE_PART_TAKE        = 'part_take';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_pocket';
    }

    public static function instantiate($row)
    {
        return self::getInstance($row['item_type']);
    }

    /**
     * @param $item_type
     * @return QuestPocketPartReward|QuestPocketPartValidate|QuestPocketPartTask|QuestPocketPartTake
     * @throws \Exception
     */
    public static function getInstance($item_type)
    {
        switch ($item_type) {
            case self::TYPE_PART_REWARD:
                return new QuestPocketPartReward();
                break;
            case self::TYPE_PART_VALIDATE:
                return new QuestPocketPartValidate();
                break;
            case self::TYPE_PART_TASK:
                return new QuestPocketPartTask();
                break;
            case self::TYPE_PART_TAKE:
                return new QuestPocketPartTake();
                break;
        }

        throw new \Exception('Вид списка не найден', 420);
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
            [['item_id', 'item_type', 'name', 'condition'], 'required'],
            [['item_id', 'updated_at', 'created_at', 'dialog_finish_id'], 'integer'],
            [['item_type', 'name', 'condition'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'item_type' => 'Item Type',
            'name' => 'Name',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'dialog_finish_id' => 'Диалог при завершении',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestPocketQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestPocketQuery(get_called_class());
    }

    public function getPocketItems()
    {
        return $this->hasMany(QuestPocketItem::className(), ['pocket_id' => 'id']);
    }

    public function getPart()
    {
        return $this->hasOne(QuestPart::className(), ['item_id' => 'id']);
    }

    public static function getConditions()
    {
        return [
            self::TYPE_AND => 'AND',
            self::TYPE_OR  => 'OR'
        ];
    }
}
