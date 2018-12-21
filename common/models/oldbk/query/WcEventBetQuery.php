<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[\common\models\oldbk\WcEventBet]].
 *
 * @see \common\models\oldbk\WcEventBet
 */
class WcEventBetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\oldbk\WcEventBet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\WcEventBet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
