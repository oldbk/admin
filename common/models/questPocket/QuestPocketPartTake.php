<?php

namespace common\models\questPocket;

use common\models\query\QuestPocketQuery;
use common\models\QuestPart;
use Yii;

/**
 * Class QuestPocketPartReward
 * @package common\models\questPocket
 *
 * @property QuestPart $part
 */
class QuestPocketPartTake extends QuestPocket
{
    public function init()
    {
        $this->item_type = self::TYPE_PART_TAKE;
        parent::init();
    }

    /**
     * @return QuestPocketQuery
     */
    public static function find()
    {
        return new QuestPocketQuery(get_called_class(), ['item_type' => self::TYPE_PART_TAKE]);
    }

    public function beforeSave($insert)
    {
        $this->item_type = self::TYPE_PART_TAKE;
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasOne(QuestPart::className(), ['id' => 'item_id']);
    }
}
