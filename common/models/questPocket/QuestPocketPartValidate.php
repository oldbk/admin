<?php

namespace common\models\questPocket;

use common\models\query\QuestPocketQuery;
use common\models\QuestPart;
use Yii;

/**
 * Class QuestPocketPartValidate
 * @package common\models\questPocket
 *
 * @property QuestPart $part
 */
class QuestPocketPartValidate extends QuestPocket
{
    public function init()
    {
        $this->item_type = self::TYPE_PART_VALIDATE;
        parent::init();
    }

    public static function find()
    {
        return new QuestPocketQuery(get_called_class(), ['item_type' => self::TYPE_PART_VALIDATE]);
    }

    public function beforeSave($insert)
    {
        $this->item_type = self::TYPE_PART_VALIDATE;
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
