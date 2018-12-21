<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\QuestMedal]].
 *
 * @see \common\models\QuestMedal
 */
class QuestMedalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\QuestMedal[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\QuestMedal|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
