<?php

namespace common\models\query\pool;

/**
 * This is the ActiveQuery class for [[\common\models\pool\PoolPocketItemInfo]].
 *
 * @see \common\models\pool\PoolPocketItemInfo
 */
class PoolPocketItemInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolPocketItemInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolPocketItemInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
