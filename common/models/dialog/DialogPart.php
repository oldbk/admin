<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.05.2016
 */

namespace common\models\dialog;


use common\models\query\DialogQuery;
use common\models\QuestPart;

/**
 * Class DialogPart
 * @package common\models\dialog
 *
 * @property QuestPart $part
 */
class DialogPart extends Dialog
{
    public function init()
    {
        $this->item_type = self::TYPE_PART;
        parent::init();
    }

    public static function find()
    {
        return new DialogQuery(get_called_class(), ['item_type' => self::TYPE_PART]);
    }

    public function beforeSave($insert)
    {
        $this->item_type = self::TYPE_PART;
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