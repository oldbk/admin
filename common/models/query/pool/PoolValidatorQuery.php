<?php

namespace common\models\query\pool;

/**
 * This is the ActiveQuery class for [[\common\models\pool\PoolValidator]].
 *
 * @see \common\models\pool\PoolValidator
 */
class PoolValidatorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolValidator[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolValidator|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
