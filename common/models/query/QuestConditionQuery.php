<?php

namespace common\models\query;
use common\models\QuestCondition;

/**
 * This is the ActiveQuery class for [[\common\models\QuestCondition]].
 *
 * @see \common\models\QuestCondition
 */
class QuestConditionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/


    public function quest()
    {
        return $this->andWhere('item_type = :item_type', [':item_type' => QuestCondition::ITEM_TYPE_QUEST]);
    }

    public function part()
    {
        return $this->andWhere('item_type = :item_type', [':item_type' => QuestCondition::ITEM_TYPE_PART]);
    }

    /**
     * @inheritdoc
     * @return \common\models\QuestCondition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\QuestCondition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
