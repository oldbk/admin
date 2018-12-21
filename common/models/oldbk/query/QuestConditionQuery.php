<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[\common\models\oldbk\QuestCondition]].
 *
 * @see \common\models\oldbk\QuestCondition
 */
class QuestConditionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\oldbk\QuestCondition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\QuestCondition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
