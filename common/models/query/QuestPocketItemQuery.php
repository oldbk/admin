<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\QuestPocketItem]].
 *
 * @see \common\models\QuestPocketItem
 */
class QuestPocketItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\QuestPocketItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\QuestPocketItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
