<?php

namespace common\models\query\pool;

/**
 * This is the ActiveQuery class for [[\common\models\pool\PoolAssign]].
 *
 * @see \common\models\pool\PoolAssign
 */
class PoolAssignQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolAssign[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolAssign|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
