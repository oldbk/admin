<?php

namespace common\models\query\pool;

/**
 * This is the ActiveQuery class for [[\common\models\pool\PoolAssignRating]].
 *
 * @see \common\models\pool\PoolAssignRating
 */
class PoolAssignRatingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolAssignRating[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\pool\PoolAssignRating|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
