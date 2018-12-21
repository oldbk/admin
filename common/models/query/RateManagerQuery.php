<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\RateManager]].
 *
 * @see \common\models\RateManager
 */
class RateManagerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function active()
    {
        return $this->andWhere('[[is_deleted]]=0');
    }

    /**
     * @inheritdoc
     * @return \common\models\RateManager[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\RateManager|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
