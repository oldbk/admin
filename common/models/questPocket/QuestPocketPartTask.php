<?php

namespace common\models\questPocket;

use common\models\dialog\Dialog;
use common\models\query\QuestPocketQuery;
use common\models\QuestPart;
use Yii;

/**
 * Class QuestPocketPartReward
 * @package common\models\questPocket
 *
 * @property QuestPart $part
 * @property Dialog $dialogFinish
 */
class QuestPocketPartTask extends QuestPocket
{
    public function init()
    {
        $this->item_type = self::TYPE_PART_TASK;
        parent::init();
    }

    /**
     * @return QuestPocketQuery
     */
    public static function find()
    {
        return new QuestPocketQuery(get_called_class(), ['item_type' => self::TYPE_PART_TASK]);
    }

    public function beforeSave($insert)
    {
        $this->item_type = self::TYPE_PART_TASK;
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasOne(QuestPart::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDialogFinish()
    {
        return $this->hasOne(Dialog::className(), ['id' => 'dialog_finish_id']);
    }
}
