<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 27.08.16
 * Time: 19:33
 */

namespace common\models\validator;


use common\models\query\QuestValidatorItemQuery;

class QuestValidatorItemReward extends QuestValidatorItem
{
    public function init()
    {
        $this->parent_type = self::PARENT_TYPE_VALIDATOR_REWARD;
        parent::init();
    }

    /**
     * @return QuestValidatorItemQuery
     */
    public static function find()
    {
        return new QuestValidatorItemQuery(get_called_class(), ['parent_type' => self::PARENT_TYPE_VALIDATOR_REWARD]);
    }

    public function beforeSave($insert)
    {
        $this->parent_type = self::PARENT_TYPE_VALIDATOR_REWARD;
        return parent::beforeSave($insert);
    }

}