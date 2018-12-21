<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[StatOnline]].
 *
 * @see StatOnline
 */
class StatOnlineQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return StatOnline[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StatOnline|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
