<?php

namespace common\models\oldbk\query\pool;

/**
 * This is the ActiveQuery class for [[\common\models\oldbk\pool\PoolPocketItemInfo]].
 *
 * @see \common\models\oldbk\pool\PoolPocketItemInfo
 */
class PoolPocketItemInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\oldbk\pool\PoolPocketItemInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\pool\PoolPocketItemInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
