<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Quest]].
 *
 * @see \common\models\Quest
 */
class QuestEventQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\Quest[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Quest|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
