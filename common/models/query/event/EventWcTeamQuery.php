<?php

namespace common\models\query\event;

/**
 * This is the ActiveQuery class for [[\common\models\event\EventWcTeam]].
 *
 * @see \common\models\event\EventWcTeam
 */
class EventWcTeamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\event\EventWcTeam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\event\EventWcTeam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
