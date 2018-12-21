<?php

namespace common\models\oldbk\query;

/**
 * This is the ActiveQuery class for [[\common\models\oldbk\UsersShadows]].
 *
 * @see \common\models\oldbk\UsersShadows
 */
class UsersShadowsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\oldbk\UsersShadows[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\oldbk\UsersShadows|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
