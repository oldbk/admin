<?php

namespace common\models;

use common\models\itemInfo\BaseInfo;
use common\models\itemInfo\iItemInfo;
use common\models\query\QuestPocketItemQuery;
use common\models\questPocket\QuestPocket;
use common\models\questTask\BaseTask;
use common\models\questTask\iQuestTask;
use common\models\validator\QuestValidatorItem;
use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * Class QuestPocketItem
 * @package common\models
 *
 * @property integer $id
 * @property integer $pocket_id
 * @property integer $pocket_item_id
 * @property string $pocket_item_type
 * @property string $item_type
 * @property integer $count
 * @property integer $updated_at
 * @property integer $created_at
 * @property QuestPocketItemInfo[] $itemInfo
 * @property QuestValidatorItem[] $itemValidators
 */
class QuestPocketItem extends BaseModel
{
    /** @var iItemInfo|iQuestTask|Model */
    public $info;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_pocket_item';
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
            [['pocket_id', 'pocket_item_id', 'pocket_item_type', 'item_type', 'count'], 'required'],
            [['pocket_id', 'pocket_item_id', 'updated_at', 'created_at', 'count'], 'integer'],
            [['pocket_item_type', 'item_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pocket_id' => 'Pocket ID',
            'pocket_item_id' => 'Pocket Item ID',
            'pocket_item_type' => 'Pocket Item Type',
            'item_type' => 'Item Type',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\query\QuestPocketItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestPocketItemQuery(get_called_class());
    }

    public function getItemInfo()
    {
        return $this->hasMany(QuestPocketItemInfo::className(), ['item_id' => 'id']);
    }

    public function getItemValidators()
    {
        return $this->hasMany(QuestValidatorItem::className(), ['parent_id' => 'id']);
    }

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub

        switch ($this->pocket_item_type) {
            case QuestPocket::TYPE_PART_TASK:
                $this->info = BaseTask::getQuestTask($this->item_type);
                foreach ($this->itemInfo as $Info) {
                    $this->info->{$Info->field} = $Info->value;
                }

                break;
            default:
                $this->info = BaseInfo::getItemInfo($this->item_type);
                foreach ($this->itemInfo as $Info) {
                    $this->info->{$Info->field} = $Info->value;
                }
                break;
        }

        foreach ($this->itemValidators as $Validator) {
            $this->info->addToValidatorList($Validator);
        }
    }
}
