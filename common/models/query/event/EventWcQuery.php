<?php

namespace common\models\query\event;

/**
 * This is the ActiveQuery class for [[\common\models\event\EventWc]].
 *
 * @see \common\models\event\EventWc
 */
class EventWcQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\event\EventWc[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\event\EventWc|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
