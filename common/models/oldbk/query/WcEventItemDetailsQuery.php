<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[\common\models\oldbk\WcEventItemDetails]].
 *
 * @see \common\models\oldbk\WcEventItemDetails
 */
class WcEventItemDetailsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\oldbk\WcEventItemDetails[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\WcEventItemDetails|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
