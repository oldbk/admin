<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.05.2016
 */

namespace common\models\dialog;


use common\models\query\DialogQuery;
use common\models\Quest;

/**
 * Class DialogQuest
 * @package common\models\dialog
 *
 * @property Quest $quest
 */
class DialogQuest extends Dialog
{
    public function init()
    {
        $this->item_type = self::TYPE_QUEST;
        parent::init();
    }

    public static function find()
    {
        return new DialogQuery(get_called_class(), ['item_type' => self::TYPE_QUEST]);
    }

    public function beforeSave($insert)
    {
        $this->item_type = self::TYPE_QUEST;
        return parent::beforeSave($insert);
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuest()
    {
        return $this->hasOne(Quest::className(), ['id' => 'global_parent_id']);
    }
}