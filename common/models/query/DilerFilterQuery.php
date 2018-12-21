<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\DilerFilter]].
 *
 * @see \common\models\DilerFilter
 */
class DilerFilterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\DilerFilter[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\DilerFilter|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
