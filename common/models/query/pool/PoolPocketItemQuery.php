<?php

namespace common\models\query\pool;

/**
 * This is the ActiveQuery class for [[\common\models\pool\PoolPocketItem]].
 *
 * @see \common\models\pool\PoolPocketItem
 */
class PoolPocketItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolPocketItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolPocketItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
