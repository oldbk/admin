<?php

namespace common\models\query\pool;

/**
 * This is the ActiveQuery class for [[\common\models\pool\PoolValidatorInfo]].
 *
 * @see \common\models\pool\PoolValidatorInfo
 */
class PoolValidatorInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolValidatorInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolValidatorInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
